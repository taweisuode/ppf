<?php
/**
 *  该项目入口文件
 *  加载Library中的所有文件
 *  并初始化路由分发模块
 */
class ErrorCode {
	const test  		= 10001;

	public function get($code) {
		include PPF_PATH."/Library/Common/ErrorCodeCN.php";
		$codeCN = $lang_cn[$code];
		return $codeCN;
	}
}
?>
