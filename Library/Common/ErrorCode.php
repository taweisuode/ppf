<?php
/**
 * @desc 错误码集合类
 *
 */
class ErrorCode {
    const test  		= 10001;

    //REDIS ERROR CODE
    const NO_CFGKEY		= 5000;
    const NO_CFGPARAMS	= 5001;
    const NO_CFG_HOST	= 5002;
    const NO_CFG_PORT	= 5003;

    //提供获取错误的方法
    public function get($code) {
        include PPF_PATH."/Library/Common/ErrorCodeCN.php";
        $codeCN = $lang_cn[$code];
        return $codeCN;
    }
}
?>
