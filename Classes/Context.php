<?php

namespace Spin\Lib;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 André Spindler <typo3@andre-spindler.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Give access to different properties of the context the controller lives in
 *
 * Member of the central quad: $controller, $parameters, $configurations, $context.    <br>
 * Address it from everywhere as: $this->controller->context.
 *
 * Gives access to $TSFE and $cObj and their many properties.
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class Context extends Object {


	/**
	 * cObject
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	var $contentObject = NULL;


	/**
	 * contructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		$this->Context($parameter1, $parameter2);
	}


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function Context($parameter1 = NULL, $parameter2 = NULL) {
		parent::Object($parameter1, $parameter2);
	}


	/**
	 * @return \Spin\Lib\Object
	 */
	function getContentData() {
//		$className = tx_div::makeInstanceClassName('tx_lib_object');
//		return new $className($this->controller, $this->contentObject->data);
		return GeneralUtility::makeInstance('\\Spin\\Lib\\Object', $this->controller, $this->contentObject->data);
	}


	/**
	 * @return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	function getContentObject() {
		return $this->contentObject;
	}


	/**
	 * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject
	 * @return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	function setContentObject(&$contentObject) {
		return $this->contentObject =& $contentObject;
	}


	/**
	 * @param string $key
	 * @return array
	 */
	function getData($key) {
		return $this->contentObject->getData($key, $this->contentObject->data);
	}


	/**
	 * @return \TYPO3\CMS\Frontend\Controller\TyposcriptFrontendController
	 */
	function getFrontEnd() {
		return $GLOBALS['TSFE'];
	}


	/**
	 * @return array
	 */
	function getPageData() {
//		$className = tx_div::makeInstanceClassName('tx_lib_object');
//		return new $className($this->controller, $GLOBALS['TSFE']->page);
		return GeneralUtility::makeInstance('\\Spin\\Lib\\Object', $this->controller, $GLOBALS['TSFE']->page);
	}


}

