<?php

class tx_lib_spl_arrayIterator extends \Spin\Lib\Spl\ArrayIterator {

    function __construct($parameter1 = NULL, $parameter2 = NULL) {
        parent::ArrayObject($parameter1, $parameter2);
    }


    function tx_lib_spl_arrayIterator($parameter1 = NULL, $parameter2 = NULL) {
        parent::ArrayObject($parameter1, $parameter2);
    }

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/spl/class.tx_lib_spl_arrayIterator.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/spl/class.tx_lib_spl_arrayIterator.php']);
}