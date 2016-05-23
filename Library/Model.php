<?php
/*
*  模型基类 Model
*  主要是pdo_mysql的封装
*
*/
class Model
{
    protected $table_name;
    private $strDsn;
    private $DbConnect;
    public function __CONSTRUCT()
    {
        try{
            //mssql 需要用dblib
            // 连接数据库的字符串定义
            $this->strDsn = "mysql:host=".$database_config['host'].";dbname=".$database_config['dbname'];
            $this->DbConnect = new PDO($this->strDsn, $database_config['username'],$database_config['password']);
            $this->DbConnect->query("set names ".$database_config['charset']);
        }catch (PDOException $e) 
        {   
            var_dump(myql_get_last_message());die;
        }  
    }
    public function query($sql,$query_mode="all",$debug=false)
    {
        if($debug == true)
        {
            var_dump($sql);die;
        }else
        {
            $query = $this->DbConnect->query($sql);
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
            }else
            {
                $result = null;
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
            $result = $this->DbConnect->exec($sql);
        }
        return $result;
    }
    public function beginTransaction()
    {
        $this->DbConnect->beginTransaction();
    }
    public function rollback()
    {
        $this->DbConnect->rollback();
    }
    public function commit()
    {
        $this->DbConnect->commit();
    }
    public function destruct()
    {
        $this->DbConnect = null;
    }
}
?>
