<?php

/**
 * @desc 框架异常类
 * 通过 throw new FrameException($message,$code)来使用以及捕获异常
 */
class FrameException extends Exception {
	private $extra_data	= null;

	public function __construct($message = '', $code = 0, $extra_data = null) {
		if(!$message) {
			require_once(PPF_PATH."/Library/Common/ErrorCode.php");
			$errorCode = new ErrorCode();
			$message = $errorCode->get($code);
		}
		parent::__construct($message, $code);
		$this->extra_data	= $extra_data;
	}

	public function getExtraData() {
		return $this->extra_data;
	}
}