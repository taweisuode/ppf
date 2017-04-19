<?php
/**
 *   路由分发单例类 Dispath
 *   该类是访问入口文件时实例化该类的
 *   构造函数用来指向当前url中的module controller action  并加载这些文件并实例化
 *   并且将当前的module，controller，action 写入静态变量中
 *
 */
class Dispath
{
    private static $static_resource;
    public  static $current_module;
    public  static $current_controller;
    public  static $current_action;
    private final function __construct()
    {
        $url = $_SERVER["REQUEST_URI"];
        $module_controller_action = explode('/',$url);
        if(in_array("ppf",$module_controller_action))
        {
            $key = array_search("ppf",$module_controller_action);
        }
        $module     = !empty($module_controller_action[$key+1]) ? $module_controller_action[1] : 'Index';
        $controller = !empty($module_controller_action[$key+2]) ? $module_controller_action[2] : 'Index';
        $action     = !empty($module_controller_action[$key+3]) ? $module_controller_action[3] : 'index';
        $this::$current_module = $module;
        $this::$current_controller = $controller;
        $this::$current_action = $action;

        //增加自动加载类这个方式加载 controller，model
        spl_autoload_register(array($this, 'loadClass'));
        /*
        *  加载application 下面的所有Controller.php文件 并实例化这个类 
        *  并访问其Action方法
        */

        $controller_class_name = $controller."Controller";
        $current_controller = new $controller_class_name();

        $action_class_name = $action."Action";
        $current_controller->$action_class_name();
    }
    public static function init() 
    {
        //常用getInstance()方法进行实例化单例类，通过instanceof操作符可以检测到类是否已经被实例化
        if(!(self::$static_resource instanceof self))
        {
            self::$static_resource = new self();

        }
        return self::$static_resource;  
    }
    private  function  __clone()
    {
        echo "该dispath类禁止被克隆";
    }
    // 自动加载控制器和模型类
    private static function loadClass($class)
    {
        $controllers = APPLICATION_PATH.'/'.Dispath::$current_module."/Controller/".$class.".php";
        $models = APPLICATION_PATH.'/'.Dispath::$current_module."/Model/".$class.".php";

        if (file_exists($controllers)) {
            // 加载应用控制器类
            include $controllers;
        } elseif (file_exists($models)) {
            //加载应用模型类
            include $models;
        } else {
            // 错误代码
        }
    }
}
?>

