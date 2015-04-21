<?php

class tx_lib_pearLoader extends \Spin\Lib\PearLoader {
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_pearLoader.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/class.tx_lib_pearLoader.php']);
}
?>
