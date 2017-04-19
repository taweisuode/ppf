<?php
/**
 *  视图类 继承于 Template类
 *
 */
class View extends Template
{
    /*
    public function show($file=null)
    {
        $current_module = Dispath::$current_module;
        $current_controller = Dispath::$current_controller;
        if(!$file)
        {
            $current_action = Dispath::$current_action;
            $html_file = APPLICATION_PATH.'/'.$current_module.'/view/'.$current_controller.'/'.$current_action.'.html';
        }else
        {
            $html_file = APPLICATION_PATH.'/'.$current_module.'/view/'.$current_controller.'/'.$file.'.html';
        }
        if(is_file($html_file))
        {
            include $html_file;
        }else
        {
            include APPLICATION_PATH.'/Index/view/Notfound/index.html';
        }
    }
    */
}
?>

