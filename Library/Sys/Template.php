<?php

/**
 *  模版引擎基类Template 主要方法有以下
 *  对配置文件的设置
 *  对缓存策略的设计
 *  对assign 赋值的方法构造
 *  对show 方法的构造
 *  构造函数中加载编译类Compile
 */

class Template
{
    protected $compile;
    public $value = array();
    public $config = array('compiledir' => 'Cache/',         //设置编译后存放的目录
        'need_compile' => true,           //是否需要重新编译 true 需要重新编译 false 直接加载缓存文件
        'suffix_cache' => '.htm',         //设置编译文件的后缀
        'cache_time' => 2000              //多长时间自动更新，单位秒  
    );

    /*
    *   构造函数实例化编译类Compile
    *
    */
    public function __CONSTRUCT() {
        $compile = new Compile();
        $this->compile = $compile;
    }

    public function set_config($key, $value) {
        if (array_key_exists($this->config)) {
            $this->config[$key] = $value;
        }
    }

    public function get_config($key) {
        if (array_key_exists($this->config)) {
            return $this->config[$key];
        }
    }

    /**
     *   缓存策略
     *   根据need_compile 是否需要重新编译
     *   以及php文件，model文件视图文件是否经过修改
     *   以及当前时间比该文件编译时间是否大于自动更新cache_time时间
     *   以上3点来决定是需要再次编译还是直接使用缓存文件
     *  @param  string $php_file php文件
     *  @param  array $model_file model文件群
     *  @param  string $html_file 视图文件
     *  @param  string $compile_file 编译文件
     *  @return bool   $default_status 是否需要重新编译
     */
    public function cache_strategy($php_file, $model_file, $html_file, $compile_file) {
        $default_status = false;
        foreach ($model_file as $key => $val) {
            if(file_exists($compile_file) && file_exists($val)) {
                if (filemtime($compile_file) < filemtime($val)) {
                    $default_status = true;
                    return $default_status;
                    die;
                    break;
                } else {
                    $default_status = false;
                }
            }
        }
        //echo filemtime($html_file) . "<br>" . filemtime($compile_file) ."<br>". time();die;
        if(file_exists($compile_file)) {
            $compile_file_time = filemtime($compile_file);
        }
        $time_minus = time() - $compile_file_time;
        if (($this->config['need_compile']) || ($time_minus > $this->config['cache_time']) || filemtime($compile_file) < filemtime($html_file) || filemtime($compile_file) < filemtime($php_file)) {
            $default_status = true;
        } else {
            $default_status = false;
        }
        //var_dump($default_status);die;
        return $default_status;
    }

    /**
     *  将变量赋值到$this->vaule中
     *  @param $key
     *  @param $value
     */
    public function assign($key, $value) {
        $this->value[$key] = $value;
    }

    /**
     *   视图跳转方法（包含了模版引擎，模版编译转化功能）
     *   @param  $file  视图跳转文件
     *
     */
    public function show($file = null) {
        /**
         *  将例如assign("test","aaa") 转化成 $test = 'aaa';
         *  所以这块是有2个赋值情况  一个是$test = 'aaa' 另一个是 $this->value['test'] = 'aaa';
         *  这里设定 可以支持多维数组传递赋值
         *  @param string $file 视图文件
         */
        foreach ($this->value as $key => $val) {
            $$key = $val;
        }
        $current_module = Dispath::$current_module;
        $current_controller = Dispath::$current_controller;
        $compile_file_path = PPF_PATH . '/' . $this->config['compiledir'] . $current_module . '/';
        $php_file = APPLICATION_PATH . '/' . $current_module . '/Controller/' . $current_controller . 'Controller.php';
        $model_file = array();
        $model_file_path = APPLICATION_PATH . '/' . $current_module . '/Model/';
        $allFile = scandir($model_file_path);
        array_splice($allFile, 0, 2);//去掉前面的 '.' 和 '..'
        //获取文件夹的所有文件
        foreach ($allFile as $key => $val) {
            if (pathinfo($val, PATHINFO_EXTENSION) == 'php') {
                $model_file_arr[] = $model_file_path . $val;
            }
        }
        /**
         *   如果未指定视图名称则默认跳至该current_action的名称
         *   在这块定义视图地址，编译php文件地址，缓存htm文件地址
         */
        if (!$file) {
            $current_action = Dispath::$current_action;
            $html_file = APPLICATION_PATH . '/' . $current_module . '/View/' . $current_controller . '/' . $current_action . '.html';
            $compile_file = $compile_file_path . md5($current_controller . '_' . $current_action) . '.php';
            $cache_file = $compile_file_path . md5($current_controller . '_' . $current_action) . $this->config['suffix_cache'];
        } else {
            $html_file = APPLICATION_PATH . '/' . $current_module . '/View/' . $current_controller . '/' . $file . '.html';
            $compile_file = $compile_file_path . md5($current_controller . '_' . $file) . '.php';
            $cache_file = $compile_file_path . md5($current_controller . '_' . $file) . $this->config['suffix_cache'];
        }
        /**
         *   如果存在视图文件html_file  则继续根据条件编译，否则跳至/Index/view/Notfound/index.html
         */
        if (is_file($html_file)) {
            /**
             *   对compile_file_path进行是否为路径的判断 如果不是 则进行创建并赋予755的权限
             */
            if (!is_dir($compile_file_path)) {
                mkdir($compile_file_path);
                //chmod($compile_file_path, 0755);
            }
            /**
             *   这3行代码是将Controller.php文件某一方法例如：$this->assign("add",'test')；
             *   将这个以键值对的方式传给在__CONSTRUCT实例化的Compile类中，并通过compile方法进行翻译成php文件
             *   最后ob_start()方法需要  include $compile_file;
             */
            if ($this->cache_strategy($php_file, $model_file_arr, $html_file, $compile_file)) {
                ob_start();
                $this->compile->value = $this->value;
                $this->compile->compile($html_file, $compile_file);
                include $compile_file;
                /**
                 *   这块是得到输出缓冲区的内容并将其写入缓存文件$cache_file中，同时将编译文件跟缓存文件进行赋予755权限
                 *   这时可以去看看Cache下面会有2个文件 一个是php文件 一个是htm文件 htm文件就是翻译成html语言的缓存文件
                 */
                $message = ob_get_contents();
                /**
                if(file_exists($compile_file)) {
                    chmod($compile_file, 0777);
                }
                if(file_exists($cache_file)) {
                    chmod($cache_file, 0777);
                }
                */
                $file_line = file_put_contents($cache_file, $message);
                ob_end_flush();
            } else {
                include $cache_file;
            }
        } else {
            include APPLICATION_PATH . '/Index/View/Notfound/index.html';
        }
    }
}

?>
