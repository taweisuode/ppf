<?php

/**
 *  数据库表抽象类 Redis_Abstract
 *  主要是redis的方法的封装
 *
 */

class Redis_Abstract
{
    public $select;
    protected $table_name;
    public $redis;
    protected static $getInstance;
    private $get_query_sql = "";

    public $DbSqlArr = array();

    private function __CONSTRUCT() {
        include_once APPLICATION_PATH . "/Config/Config.php";
        include_once APPLICATION_PATH . "/Config/Redis.php";
        include_once LIBRARY_PATH . "/Exception/PPFRedisException.php";
        try {
            $redis = new Redis();
            $redis->connect($config['redis']['host'],$config['redis']['port']);
            $redis->auth($config['redis']['password']);
            $redis->set("expire_time",$config['redis']['timeout']);
            if($redis->ping()==="+PONG") {
                $this->redis = $redis;
            }
        } catch (PPFRedisException $e) {
            var_dump($e->getMessage());die;
            die;
        }
    }

    public static function Db_init() {
        if (self::$getInstance === null) {
            self::$getInstance = new self();
        }
        return self::$getInstance;
    }
    public function set($key,$value) {
        $this->redis->set($key,$value);
    }
    public function get($key) {
        return $this->redis->get($key);
    }
    public function setex($key,$time,$value) {
        $this->redis->setex($key,$time,$value);
    }
    public function mset($arr = array()) {
        $this->redis->mset($arr);
    }
    public function mget($arr = array()) {
        $this->redis->mget($arr);
    }
    public function get_query_sql() {
        return $this->get_query_sql;
    }
    public function set_query_sql($sql) {
        $this->get_query_sql = $sql;
    }
    public function select($field = "*") {
        $new_field = "";
        $field_arr = explode(",", $field);
        foreach ($field_arr as $key => $val) {
            $new_field .= $val . ",";
        }
        $new_field = substr($new_field, 0, strlen($new_field) - 1);
        $sql = "select " . $new_field;
        $this->DbSqlArr['_select'] = $sql;
        return $this;
    }

    public function from($table_name = "") {
        if (empty($table_name)) {
            $mysql_error = "tableName can  not be null";
            return $mysql_error;
            die;
        } else {
            $this->DbSqlArr['_from'] = " from " . $table_name;
            return $this;
        }
    }

    public function where($where_list) {
        $where = " where ";
        if(is_array($where_list)) {
            foreach($where_list as $key => $val) {
                $where .= $key ." = '" . $val ."' and ";
            }
            $where = substr($where,0,strlen($where)-4);
        }else if(is_string($where_list)) {
            $where = $where . $where_list;
        }
        $this->DbSqlArr['_where'] = $where;
        return $this;
    }

    public function orderby($field = "id", $sort_type = "asc") {
        $this->DbSqlArr['_orderby'] = " order by " . $field  ." ". $sort_type;
        return $this;
    }

    public function limit($offset = '0', $rows = "") {
        $this->DbSqlArr['_limit'] = " limit " . $offset . "," . $rows;
        return $this;
    }

    public function fetchAll() {
        if (!empty($this->DbSqlArr)) {
            $sql = implode("", $this->DbSqlArr);
            $this->set_query_sql($sql);
            $result = $this->query($sql,'all',false);
            $this->DbSqlArr = "";
            return $result;
        }
    }
    public function fetchRow() {
        if (!empty($this->DbSqlArr)) {
            $sql = implode("", $this->DbSqlArr);
            $this->set_query_sql($sql);
            $result = $this->query($sql,'row',false);
            $this->DbSqlArr = "";
            return $result;
        }
    }
    public function insert($table_name,$insert_list) {
        $insertkeysql = $insertvaluesql = $comma = '';
        foreach ($insert_list as $insert_key => $insert_value) {
            $insertkeysql .= $comma.'`'.$insert_key.'`';
            $insertvaluesql .= $comma.'\''.$insert_value.'\'';
            $comma = ', ';
        }
        $sql = "insert into ".$table_name."(".$insertkeysql .")values(" .$insertvaluesql. ")";
        $this->set_query_sql($sql);
        $returnid = $this->exec($sql);
        if($returnid) {
            return $this->DbConnect->lastInsertId();
        }else {
            return false;
        }
    }
    public function delete($table_name) {
        $sql = "";
        if($this->DbSqlArr['_where']) {
            $sql =  "delete from ".$table_name ." ".$this->DbSqlArr['_where'];
        }else {
            var_dump("delete 语句请输入where条件");die;
        }
        $this->set_query_sql($sql);
        return $this->exec($sql);
    }
    public function update($table_name,$set_list) {
        $set = "";
        if(is_string($set_list)) {
            $set = $set.$set_list." ";
        }else if(is_array($set_list)) {
            $tmpList = "";
            foreach($set_list as $key => $val) {
                $tmpList .= $key ." = '" . $val ."' , ";
            }
            $set = $set.$tmpList;
            $set = substr($set,0,strlen($set)-2);
        }
        $this->DbSqlArr['_update'] = "update " .$table_name." set ".$set . " ";
        $sql = "";
        if($this->DbSqlArr['_where']) {
            $sql =  $this->DbSqlArr['_update'] . $this->DbSqlArr['_where'];
        }else {
            var_dump("update 语句请输入where条件");die;
        }
        $this->set_query_sql($sql);
        return $this->exec($sql);

    }


    public function query($sql, $query_mode = "all", $debug = false) {
        $result = array();
        if ($debug == true) {
            var_dump($sql);die;
        } else {
            try {
                //使用预处理语句来执行sql
                $query = $this->DbConnect->query($sql);
                if ($query) {
                    $query->setFetchMode(PDO::FETCH_ASSOC);
                    if ($query_mode == "all") {
                        $result = $query->fetchAll();
                    } else if ($query_mode == "row") {
                        $result = $query->fetch();
                    }
                }
            } catch (PDOException $e) {
                var_dump($e->getMessage());
            }
        }
        return $result;
    }

    public function exec($sql, $debug = false) {
        if ($debug == true) {
            var_dump($sql);
            die;
        } else {
            $result = $this->DbConnect->exec($sql);
        }
        return $result;
    }

    public function beginTransaction() {
        $this->DbConnect->beginTransaction();
    }

    public function rollback() {
        $this->DbConnect->rollback();
    }

    public function commit() {
        $this->DbConnect->commit();
    }

    public function destruct() {
        $this->DbConnect = null;
    }
}

