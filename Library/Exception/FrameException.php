<?php
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

	public function append_message($msg, $separator = "; ") {
		if (!is_string($msg)) {
			return false;
		}

		$this->message	.= $separator . $msg;
	}

	public function getExtraData() {
		return $this->extra_data;
	}
}