<?php

class tx_lib_formBase extends \Spin\Lib\FormBase {

	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		parent::FormBase($parameter1, $parameter2);
	}


	function tx_lib_formBase($parameter1 = NULL, $parameter2 = NULL) {
		parent::FormBase($parameter1, $parameter2);
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_formBase.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_formBase.php']);
}
