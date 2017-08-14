<?php
/**
 *  编译类  Compile
 *  正则匹配式可拓展  可设定多个编译模版
 *
 */
class Compile
{
    public $config = array(
        'compiledir' => 'Cache/',         //设置编译后存放的目录
        'suffix_cache' => '.htm',         //设置编译文件的后缀
    );
    public $value = array();
    public $compare_pattern = array();
    public $compare_destpattern = array();
    public $compare_include_pattern = "";
    public function __CONSTRUCT()
    {
        //添加include 模版
        $this->compare_pattern[] = '#\{include (.*?)\}#';

        //简单的key value赋值
        $this->compare_pattern[] = '#\{\\$(.*?)\}#';
        //if条件语句实现
        $this->compare_pattern[] = '#\{if (.*?)\}#';
        $this->compare_pattern[] = '#\{elseif(.*?)\}#';
        $this->compare_pattern[] = '#\{else(.*?)\}#';
        $this->compare_pattern[] = '#\{/if\}#';
        //foreach实现
        $this->compare_pattern[] = '#\{foreach name=\\$(.*?) item=(.*?) value=(.*?)\}#';
        $this->compare_pattern[] = '#\{\\$(.*?)\}#';
        $this->compare_pattern[] = '#\{/foreach\}#';
        //支持原生php语言实现
        $this->compare_pattern[] = '#\{php (.*?)\}#';
        $this->compare_pattern[] = '#\{/php\}#';

        $this->compare_pattern[] = '#\{compile_include (.*?)\}#';


        //以下是上面几个模版编译后的php语言实现

        $this->compare_destpattern[] = "<?php include PPF_PATH.'/'.\$this->config['compiledir'].".Dispath::$current_module.".'/'.md5('".Dispath::$current_controller.'_'.Dispath::$current_action.'_'."\\1').'.php'; ?>";

        $this->compare_destpattern[] = "<?php echo $\\1;?>";

        $this->compare_destpattern[] = "<?php if(\\1){ ?>";
        $this->compare_destpattern[] = "<?php }else if(\\1){ ?>";
        $this->compare_destpattern[] = "<?php }else{ ?>";
        $this->compare_destpattern[] = "<?php }?>";
        $this->compare_destpattern[] = "<?php foreach(\$\\1 as \$\\2 => \$\\3){?>";
        $this->compare_destpattern[] = '<?php echo $\\1; ?>';
        $this->compare_destpattern[] = "<?php } ?>";

        $this->compare_destpattern[] = "<?php \\1 ";
        $this->compare_destpattern[] = "?>";

        $this->compare_destpattern[] = '<?php include "'.APPLICATION_PATH.'/'.Dispath::$current_module.'/View/'.'\\1";?>';

        $this->compare_include_pattern = '#\{include (.*?)\}#';
    }
    /**
     *   基本的编译功能实现 讲视图文件通过正则匹配编译并写入到php文件中
     *
     */
    public function compile($pre_compile_file,$dest_compile_file)
    {
        $compile_content = preg_replace($this->compare_pattern,$this->compare_destpattern,file_get_contents($pre_compile_file));
        file_put_contents($dest_compile_file,$compile_content);
    }
    /**
     * @desc 这块内容是先将include编译，然后生成在对应cache目录下的php文件，
     * 将数组回传给Template.php然后在Template.php进行编译
     *
     */
    public function match_include_file($file) {
        $matchArr = array();
        $match_file = preg_match_all($this->compare_include_pattern,file_get_contents($file),$matchArr);
        if($match_file && !empty($matchArr[1])) {
            $include_file_arr = array();
            foreach($matchArr[1] as $key => $val) {
                $compile_file_path = $this->get_compile_file_path();
                $destpatternFile = APPLICATION_PATH."/".Dispath::$current_module."/View/".$val;
                $compile_content = preg_replace($this->compare_pattern,$this->compare_destpattern,file_get_contents($destpatternFile));
                $compile_file = $compile_file_path . md5(Dispath::$current_controller . '_' . Dispath::$current_action.'_'.$val) . '.php';
                file_put_contents($compile_file,$compile_content);
                $include_file_arr[] = $compile_file;
            }
            return $include_file_arr;
        }else {
            return false;
        }
    }
    private function get_compile_file_path() {
        $compile_file_path = PPF_PATH . '/' . $this->config['compiledir'] . Dispath::$current_module . '/';
        return $compile_file_path;
    }
}
?>
