<?php

class tx_lib_object extends \Spin\Lib\Object {

	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		parent::Object($parameter1, $parameter2);
	}


	public function tx_lib_object($parameter1 = NULL, $parameter2 = NULL) {
		parent::Object($parameter1, $parameter2);
	}

}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_object.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_object.php']);
}
