<?php

class tx_lib_image extends \Spin\Lib\Image {

	function __construct() {
		parent::Image();
	}


	function tx_lib_image() {
		parent::Image();
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_image.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_image.php']);
}
