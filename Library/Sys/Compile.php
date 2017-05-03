<?php
/**
 *  编译类  Compile
 *  正则匹配式可拓展  可设定多个编译模版
 *
 */
class Compile
{
    public $value = array();
    public $compare_pattern = array();
    public $compare_destpattern = array();
    public function __CONSTRUCT()
    {
        //简单的key value赋值
        $this->compare_pattern[] = '#\{\\$(.*?)\}#';
        //if条件语句实现
        $this->compare_pattern[] = '#\{if (.*?)\}#';
        $this->compare_pattern[] = '#\{elseif(.*?)\}#';
        $this->compare_pattern[] = '#\{else(.*?)\}#';
        $this->compare_pattern[] = '#\{/if\}#';
        //foreach实现
        $this->compare_pattern[] = '#\{foreach name=\\$(.*?)\}#';
        $this->compare_pattern[] = '#\{\\$(key|val).\}#';
        $this->compare_pattern[] = '#\{/foreach\}#';
        //支持原生php语言实现
        $this->compare_pattern[] = '#\{php (.*?)\}#';
        $this->compare_pattern[] = '#\{/php\}#';

        //以下是上面几个模版编译后的php语言实现
        $this->compare_destpattern[] = "<?php echo $\\1;?>";

        $this->compare_destpattern[] = "<?php if(\\1){ ?>";
        $this->compare_destpattern[] = "<?php }else if(\\1){ ?>";
        $this->compare_destpattern[] = "<?php }else{ ?>";
        $this->compare_destpattern[] = "<?php }?>";

        $this->compare_destpattern[] = "<?php foreach(\$\\1 as \$key => \$val){?>";
        $this->compare_destpattern[] = '<?php echo $\\1; ?>';
        $this->compare_destpattern[] = "<?php } ?>";

        $this->compare_destpattern[] = "<?php \\1 ";
        $this->compare_destpattern[] = "?>";
    }
    /**
     *   基本的编译功能实现 讲视图文件通过正则匹配编译并写入到php文件中
     *
     */
    public function compile($pre_compile_file,$dest_compile_file)
    {    
        //echo $dest_compile_file;die;
        $compile_content = preg_replace($this->compare_pattern,$this->compare_destpattern,file_get_contents($pre_compile_file));
        file_put_contents($dest_compile_file,$compile_content);
    }
}
?>
