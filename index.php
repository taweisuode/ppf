<?php
/* 
*  该项目入口文件
*  加载Library中的所有文件
*  并初始化路由分发模块
*/
error_reporting(E_ALL ^ E_NOTICE);
$path = str_replace(DIRECTORY_SEPARATOR,'/',dirname(__FILE__));
define("PPF_PATH",$path);
require_once(PPF_PATH.'/Application/Config/Config.php');
require_once(PPF_PATH.'/Application/Config/Database.php');
$allFile = scandir(PPF_PATH.'/Library/');
array_splice($allFile,0,2);//去掉前面的 '.' 和 '..'
//获取文件夹的所有文件
require_once(PPF_PATH.'/Library/Sys/Db_Table_Abstract.php');
foreach($allFile as $key => $val)
{   
    if(pathinfo($val,PATHINFO_EXTENSION) == 'php')
    {   
        //加载Library下面的所有文件
       require_once(PPF_PATH.'/Library/'.$val); 
    }   
}   
//初始化路由分发 根据request_uri来分发到各个控制器方法
$dispath = Dispath::init();
?>
