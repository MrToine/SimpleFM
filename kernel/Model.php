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

    public function findCount($conditions) {
        $res = $this->findFirst(array(
            'fields' => 'COUNT('.$this->primary_key.') as count',
            'conditions' => $conditions
        ));

        return $res->count;
    }
}
