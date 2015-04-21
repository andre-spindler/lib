<?php

class tx_lib_spl_arrayObject extends \Spin\Lib\Spl\ArrayObject {

    public function __construct($array = array(), $flags = 0, $iteratorClass = '\\Spin\\Lib\\Spl\\ArrayIterator') {
        parent::ArrayObject($array, $flags, $iteratorClass);
    }


    function tx_lib_spl_arrayObject($array = array(), $flags = 0, $iteratorClass = '\\Spin\\Lib\\Spl\\ArrayIterator') {
        parent::ArrayObject($array, $flags, $iteratorClass);
    }

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/spl/class.tx_lib_spl_arrayObject.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/lib/spl/class.tx_lib_spl_arrayObject.php']);
}
