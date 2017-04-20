<?php
/**
 *   控制器基类Controller
 *   所有的控制器都继承于他
 *   构造方法中需要实例化View类，并加载所有的该module下面的model.php文件
 */
class Controller
{
    protected $view;
    public function __CONSTRUCT()
    {
        $this->view = new View();
        //自动加载所有的model文件
        //$autoload_model_path = APPLICATION_PATH.'/'.Dispath::$current_module.'/Model';
        //var_dump($autoload_model_path);die;
        //var_dump($autoload_model_path);die;
        //$allFile = scandir($autoload_model_path);
/*        array_splice($allFile,0,2);//去掉前面的 '.' 和 '..'
        //获取文件夹的所有文件
        foreach($allFile as $key => $val)
        {   
            if(pathinfo($val,PATHINFO_EXTENSION) == 'php')
            {   
                //加载Model下面的所有文件
               require_once($autoload_model_path.'/'.$val); 
            }   
        }*/
    }
}
?>
