<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/

class Model {

    static $connections = array();

    public $dbConf = 'default';
    public $table = false;
    public $db;
    public $primary_key = "id";
    public $id;

    public $errors = array();

    public function __construct() {
        if($this->table === false) {
            $this->table = strtolower(get_class($this)).'s';
        }
        $config = ConfigDatabase::$databases[$this->dbConf];
        if(isset(Model::$connections[$this->dbConf])) {
            $this->db = Model::$connections[$this->dbConf];
            return true;
        }
        try {
            $pdo = new PDO(
                'mysql:host='.$config['host'].';dbname='.$config['database'].';',
                $config['user'],
                $config['password'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$config['set_name'])
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            Model::$connections[$this->dbConf] = $pdo;
            $this->db = $pdo;
        }catch(PDOException $e) {
            if(ConfigApp::$debug){
                die($e->getMessage());
            }else{
                die('Connection failed.');
            }
        }
    }

    public function find($query) {

        $sql = 'SELECT ';

        if(isset($query['fields'])) {
            if(is_array($query['fields'])) {
                $sql .= implode(', ', $$query['fields']);
            }else{
                $sql .= $query['fields'];
            }
        }else{
            $sql .= '*';
        }

        $sql .= ' FROM '.$this->table.' as '.get_class($this).' ';

        if(isset($query['conditions'])) {
            $sql .= 'WHERE ';
            if(!is_array($query['conditions'])){
                    $sql .= $query['conditions'];
            }else{
                $cond = array();
                foreach($query['conditions'] as $k => $v) {
                    if(!is_numeric($v)){
                        $v = $this->db->quote($v);
                    }
                    $cond[] = "$k = $v";
                }
                $sql .= implode(' AND ', $cond);
            }
        }

        if(isset($query['limit'])) {
            $sql .= ' LIMIT '.$query['limit'];
        }

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($query) {
        return current($this->find($query));
    }

    public function findCount($conditions=null) {
        if($conditions) {
            $res = $this->findFirst(array(
                'fields' => 'COUNT('.$this->primary_key.') as count',
                'conditions' => $conditions
            ));
        }else {
            $res = $this->findFirst(array('fields' => 'COUNT('.$this->primary_key.') as count'));
        }

        return $res->count;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primary_key} = $id";
        $this->db->query($sql);
    }

    public function save($data, $scape=false) {
        $key = $this->primary_key;
        $fields = array();
        $d = array();
        foreach ($data as $k => $v) {
            if($k != $this->primary_key){
                $fields[] .= "$k=:$k";
                $d[":$k"] = $v;
            }elseif(!empty($v)){
                $d[":$k"] = $v;
            }
        }
        if(isset($data->$key) && !empty($data->$key) || $scape == true){
            $sql = 'UPDATE '.$this->table.' SET '.implode(',' ,$fields).' WHERE '.$key. '=:'.$key;
            $this->id = $data->$key;
            $action = "update";
        }else{
            $sql = 'INSERT INTO '.$this->table.' SET '.implode(',' ,$fields);
            $action = "insert";
        }
        $pre = $this->db->prepare($sql);
        $pre->execute($d);
        if($action == "insert"){
            $this->id = $this->db->lastInsertId();
        }
        return true;
    }

    // VALIDATION FORM
    function validate($data) {
        $errors = array();
        $reg_expression = "";
        foreach ($this->validate as $key => $value) {
            if($value['rule'] == "alphanumeric_hyphen_repeat"){
                $reg_expression = "([a-z0-9\-]+)";
            }
            if(!isset($data->$key)) {
                $errors[$key] = $value['message'];
            }else{
                if($value['rule'] == 'notEmpty'){
                    if(empty($data->$key)){
                        $errors[$key] = $value['message'];
                    }
                }elseif($value['rule'] == 'clean_xss') {
                    if(preg_match('/\<script(.*?)?\>(.|\s)*?\<\/script\>/i', $data->content)){
                        $errors[$key] = $value['message'];
                    }
                }elseif(!preg_match('/^'.$reg_expression.'$/', $data->$key)){
                    $errors[$key] = $value['message'];
                }
            }
        }
        $this->errors = $errors;
        if(empty($errors)) {
            return true;
        }
        return false;
    }
}
