<?php
/**
 * @desc 错误码集合类
 *
 */
class ErrorCode {
	const test  		= 10001;

    //提供获取错误的方法
	public function get($code) {
		include PPF_PATH."/Library/Common/ErrorCodeCN.php";
		$codeCN = $lang_cn[$code];
		return $codeCN;
	}
}
?>
