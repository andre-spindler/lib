<?php

class tx_lib_parameters extends \Spin\Lib\Parameters {

	function __construct($controller = NULL) {
		parent::Parameters($controller);
	}


	function tx_lib_parameters($controller = NULL) {
		parent::Parameters($controller);
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_parameters.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_parameters.php']);
}
