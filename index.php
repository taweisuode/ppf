<?php
/**
 *  该项目入口文件
 *  加载Library中的所有文件
 *  并初始化路由分发模块
 */
error_reporting(E_ALL ^ E_NOTICE);
$path = str_replace(DIRECTORY_SEPARATOR,'/',dirname(__FILE__));
define("PPF_PATH",$path);
require_once(PPF_PATH.'/Application/Config/Config.php');
if(is_file(PPF_PATH.'/Application/Config/Database.php')) {
    require_once(PPF_PATH.'/Application/Config/Database.php');
}else {
    echo "请在根目录/Application/Config下创建Database.php这个文件(可以拷贝自Database_default.php文件)";die;
}
if(!is_dir(PPF_PATH."/Cache")) {
     echo "请在根目录下创建Cache这个目录";die;
}
$allFile = scandir(PPF_PATH.'/Library/Sys/');
array_splice($allFile,0,2);//去掉前面的 '.' 和 '..'
//获取文件夹的所有文件
foreach($allFile as $key => $val)
{   
    if(pathinfo($val,PATHINFO_EXTENSION) == 'php')
    {   
        //加载Library/Sys下面的所有文件
       require_once(PPF_PATH.'/Library/Sys/'.$val);
    }   
}   
//初始化路由分发 根据request_uri来分发到各个控制器方法
$dispath = Dispath::init();
?>
