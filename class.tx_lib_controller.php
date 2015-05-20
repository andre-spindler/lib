<?php

class tx_lib_controller extends \Spin\Lib\Controller {

	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		parent::constructController($parameter1, $parameter2);
	}


	function tx_lib_controller($parameter1 = NULL, $parameter2 = NULL) {
		parent::constructController($parameter1, $parameter2);
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_controller.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_controller.php']);
}
