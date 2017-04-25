<?php
    /**
     * @desc 截取2个字符之间的字符串
     * @param $str   (待切割的字符串)
     * @param $mark1 (分隔符1)
     * @param $mark2 (分隔符2)
     * @return bool|string
     */
    function _getNeedBetween($str,$mark1,$mark2) {
        $start =stripos($str,$mark1);
        $end =stripos($str,$mark2);
        if(($start ===false||$end ===false)||$start >= $end)
            return false;
        $res=substr($str,($start+1),($end-$start-1));
        return $res;
    }
    /**
     * @desc 对输入的数组或者字符串进行过滤处理
     * @param $string
     * @param $force  (是否强制过滤)
     * @return string|array
     */
    function daddslashes($string, $force = 0) { 
        if(!$GLOBALS['magic_quotes_gpc'] || $force) { 
            if(is_array($string)) { 
                foreach($string as $key => $val) { 
                    $string[$key] = daddslashes($val, $force); 
                    }   
                } else { 
                    $string = addslashes($string); 
                }   
            }   
        return $string; 
    } 
