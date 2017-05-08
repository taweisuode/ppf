<?php
error_reporting(E_ALL ^ E_NOTICE);
class IndexModel extends Model
{
    protected $_tablename = 'movielist';
    public function test() {
        /*
            $sql = "select * from t_sys_user where user_sn = '".$user_sn."'";
            $result = $this->query($sql);
            return $result;
        */
        //$sql = "select * from movielist limit 10";
        //$query = $this->db->query($sql);
        $select = $this->db->select("movie_name,movie_pic,movie_url,movie_says")->from($this->_tablename);
        //$select  = $this->db->from($this->_tablename);
        $whereArr = array(
            'id' => 1,
            'movie_name' => '长发公主'
        );
        $select  = $this->db->where($whereArr);
        $select  = $this->db->orderby("id","desc");
        $select  = $this->db->limit(0,10);
        $result  = $select->fetchAll();
        $result = $select->fetchRow();
        //$result = $select->fetchAll();
/*        $select = $this->db->select("oid,product_title,dest_name")
                ->db->from($_tablename)
                ->db->where(array("product_id"=>"1751939"))
                ->limit(0,10)
                ->orderby("oid","desc");
        $data = $this->db->fetchAll($select);*/
        return $result;
    }
}
?>
