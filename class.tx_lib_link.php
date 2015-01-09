<?php

class tx_lib_link extends \Spin\Lib\Link {

	function __construct($cObjectClass = 'tslib_cObj') {
		parent::Link($cObjectClass);
	}


	function tx_lib_link($cObjectClass = 'tslib_cObj') {
		parent::Link($cObjectClass);
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_link.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_link.php']);
}
