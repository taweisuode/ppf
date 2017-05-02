<?php
error_reporting(E_ALL ^ E_NOTICE);
class IndexModel extends Model
{
    protected $_tablename = 'orders';
    public function test() {
        /*
            $sql = "select * from t_sys_user where user_sn = '".$user_sn."'";
            $result = $this->query($sql);
            return $result;
        */
        $sql = "select * from movielist limit 10";
        $query = $this->db->query($sql);
        /*$select = $this->db->select("oid,user_id,product_id");
        $select  = $this->db->from($this->_tablename);
        $select  = $this->db->where("product_id = '793131'");
        $select  = $this->db->orderby("oid","desc");
        $select  = $this->db->limit(1,10);*/
        //$result = $select->fetchAll();
/*        $select = $this->db->select("oid,product_title,dest_name")
                ->db->from($_tablename)
                ->db->where(array("product_id"=>"1751939"))
                ->limit(0,10)
                ->orderby("oid","desc");
        $data = $this->db->fetchAll($select);*/
        return $query;
    }
}
?>
