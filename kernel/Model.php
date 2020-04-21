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

    public function __construct() {
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
        if($this->table === false) {
            $this->table = strtolower(get_class($this)).'s';
        }
    }

    public function find($query) {

        $sql = 'SELECT * FROM '.$this->table.' as '.get_class($this).' ';

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

        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($query) {
        return current($this->find($query));
    }
}
