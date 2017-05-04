<?php
/**
 *   控制器基类Controller
 *   所有的控制器都继承于他
 *   构造方法中需要实例化View类，并加载所有的该module下面的model.php文件
 */
class Controller
{
    private $loadException  = "FrameException";
    private $hasException   = false;
    protected $view;
    public function __CONSTRUCT()
    {
    
        //默认导入TestException异常类
        $this->load('Exception/FrameException');
        $this->load('Common/ErrorCode');
        //设置异常处理函数
        restore_exception_handler();
        set_exception_handler(array($this,"setExceptionHandler"));

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
    public function setExceptionHandler(Exception $e) {
        $this->hasException = true;
        $this->showError($e);
    }
    public function showError($msg, $code = -1) {
        $code   = $msg->getCode();
        $desc   = $msg->getMessage();
        $return = array(
            'e' =>  array(
                'code'  => $code,
                'desc'  => $desc
            )
        );
        echo json_encode($return);die;
    
    }
    public function load($path) {
        if(is_array($path)) {
            foreach($path as $key => $val) {
                $this->load($val);
            }
        }else {
            require_once(PPF_PATH.'/Library/'.$path.".php");
        }
    }
}
?>
