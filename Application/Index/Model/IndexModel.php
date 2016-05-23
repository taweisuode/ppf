<?php
class Index_IndexModel extends Model
{
    protected $table_name = 't_sys_user';
    public function getName($user_name)
    {
        $sql = "select * from t_sys_user where user_name = '".$user_name."'";
        $result = $this->query($sql);
        return $result;
    }
}
?>
