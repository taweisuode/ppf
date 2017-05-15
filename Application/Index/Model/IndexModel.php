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
            'id' => 2
        );
        $select  = $this->db->where($whereArr);
        $set = array(
            'movie_pic' => 'moviepic111.jpg',
            'movie_says'=> '很好看很好看的电影,电影音乐很好的11111'
        );
        $insertData = array(
            'movie_name'=>"test",
            'movie_pic' => '111.jpg',
            'movie_url' => 'www.baidu.com',
            'addtime'   => 'November 06,2017',
            'movie_says'=> '很好看很好看的电影，电影画面很炫丽的'
        );
        //$return = $this->db->insert($this->_tablename,$insertData);
        $deleteData = array(
            'id' => '9'
        );
        $this->db->where($deleteData);
        //$result = $this->db->delete($this->_tablename);
        //$select = $this->db->update($this->_tablename,$set);
        //$select  = $this->db->orderby("id","desc");
        //$select  = $this->db->limit(0,10);
        $result  = $select->fetchRow();
        return $result;
    }
}
?>
