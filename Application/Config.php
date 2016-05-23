<?php
define("APPLICATION_PATH",PPF_PATH.'/Application');
define("DEFAULT_CONTROLLER_PATH",APPLICATION_PATH.'/Index/Controller/IndexController.php');
define("DEFAULT_MODEL_PATH",APPLICATION_PATH.'/Index/Model/IndexModel.php');
define("DEFAULT_VIEW_PATH",APPLICATION_PATH.'/Index/View/index.html');
define('PUBLIC_PATH',PPF_PATH.'/Public/');
define('CSS_PATH',PPF_PATH.'/Public/Css/');
define('JS_PATH',PPF_PATH.'/Public/Js/');
define('IMAGE_PATH',PPF_PATH.'/Public/Image/');
/*
*  数据库配置文件 php7后 define 可以定义数组变量
*/
$database_config = array(
    'host' => '127.0.0.1',
    'username'=>'root',
    'password'=>'vertrigo',
    'dbname'=>'cric_crm',
    'charset'=>'utf8',
    );
//define('PDO_CONFIG',$database_config);
?>
