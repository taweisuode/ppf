<?php

/**
 *  模型基类 Model
 *  主要是pdo_mysql的封装
 *
 */
class Model extends Db_Table_Abstract
{
    protected $table_name;
    private $strDsn;
    public $db;
    public function __CONSTRUCT($model_name = "") {
        include APPLICATION_PATH."/Config/Config.php";
        $this->db = $this::Db_init();
    }
    public function getList($sql,$query_mode="all",$debug=false)
    {
        if($debug == true)
        {
            var_dump($sql);die;
        }else
        {
            try
            {
                //使用预处理语句来执行sql
                $query = $this->db->query($sql);
                if($query)
                {
                    $query->setFetchMode(PDO::FETCH_ASSOC);
                    if($query_mode == "all")
                    {
                        $result = $query->fetchAll();
                    }else if($query_mode == "row")
                    {
                        $result = $query->fetch();
                    }
                }
            }catch(PDOException $e){
                var_dump($e->getMessage());
            }
        }
        return $result;
    }
    public function exec($sql, $debug=false)
    {
        if($debug == true)
        {
            var_dump($sql);die;
        }else
        {
            $result = $this->db->exec($sql);
        }
        return $result;
    }
    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }
    public function rollback()
    {
        $this->db->rollback();
    }
    public function commit()
    {
        $this->db->commit();
    }
    public function destruct()
    {
        $this->db = null;
    }
}
?>
