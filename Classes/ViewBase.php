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
 * Base class for all views in tx_lib
 *
 * Depends on: tx_lib_object
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class ViewBase extends Object {

	/**
	 * @var string
	 */
	var $pathToTemplateDirectory = '';

	/**
	 * @var string
	 */
	var $dateFormatKey = 'dateFormat';

	/**
	 * @var string
	 */
	var $floatFormatKey = 'floatFormat';

	/**
	 * @var string
	 */
	var $parseFuncTextKey = 'parseFuncText';

	/**
	 * @var string
	 */
	var $parseFuncRteKey = 'parseFuncRte';

	/**
	 * @var string
	 */
	var $timeFormatKey = 'timeFormat';


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		$this->ViewBase($parameter1, $parameter2);
	}


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function ViewBase($parameter1 = NULL, $parameter2 = NULL) {
		parent::Object($parameter1, $parameter2);
	}


	//------------------------------------------------------------------------------------
	// Setters
	//------------------------------------------------------------------------------------


	/**
	 * Call this function to find the the path to the template directory.
	 *
	 * $this->pathToTemplateDirectory is checked first, if it has been set actively.
	 * If it is missing, call $configurations->get('pathToTemplateDirectory'). (RECOMMENDED)
	 * The path can make use the syntax  EXT:myextension/somepath.
	 *
	 * @return    string
	 */
	function getPathToTemplateDirectory() {
		$pathToTemplateDirectory = $this->pathToTemplateDirectory ? $this->pathToTemplateDirectory :
				$this->controller->configurations->get('pathToTemplateDirectory');
		if (!$pathToTemplateDirectory)
			$this->_die(__FILE__, __LINE__, 'Please set the path to the template directory.
			Do it either with the method setPathToTemplateDirectory($path)
			or by choosing the default name "pathToTemplateDirectory" in the TS setup.');

		return GeneralUtility::getFileAbsFileName($pathToTemplateDirectory);
	}


	//-------------------------------------------------------------------------------------
	// Getters
	//-------------------------------------------------------------------------------------


	/**
	 * Set the path of the template directory (ALTERNATIVE WAY).
	 *
	 * The DEFAULT WAY is to set the template path by the configurations object.
	 *
	 * This method gives you the possibility to specify a template path from the controller.
	 * This can become usefull, if you work with different template directories.
	 * You can make use the syntax  EXT:myextension/somepath.
	 * It will be evaluated to the absolute path by t3lib_div::getFileAbsFileName()
	 *
	 * @param    string        $pathToTemplateDirectory path to the directory containing the php templates
	 * @return    void
	 */
	function setPathToTemplateDirectory($pathToTemplateDirectory) {
		$this->pathToTemplateDirectory = GeneralUtility::getFileAbsFileName($pathToTemplateDirectory);
	}


	/**
	 * Render the template.
	 *
	 * Abstract function, to be adapted in child classes
	 *
	 * The parameter can be a key of an element in the $configurations object,
	 * that points to a filename or the filename itself.
	 *
	 * Usage:
	 *
	 * 1.) $view->render('exampleTemplateKey');
	 * 2.) $view->render('exampleTemplateFileName.php');
	 *
	 * @param      string    $configurationKeyOrFileName configuration key or filename of template file
	 * @return  string    typically an (x)html string
	 * @abstract
	 */
	function render($configurationKeyOrFileName) {
		return '<p>Abstract function: render()</p>';
	}


	//-------------------------------------------------------------------------------------
	// Getters typically called within the template
	//-------------------------------------------------------------------------------------


	/**
	 * Get human readability and localized date for a timestamp out of the internal data array.
	 *
	 * If no format parameter is provided, the function tries to find one in the configurations
	 * by using the pathKey $this->dateFormatKey.
	 *
	 * @param    mixed        $key key of internal data array
	 * @param    string        $format format string
	 * @return    string        human readable date string
	 * @see        http://php.net/strftime
	 */
	function asDate($key, $format = NULL) {
		$format = $format ? $format : $this->controller->configurations->get($this->dateFormatKey);
		if ($format) {
			return strftime($format, $this->get($key));
		} else {
			$message = 'No date format has been defined.';
			$this->_die($message, __FILE__, __LINE__);
		}

		return '';
	}


	/**
	 * Make an external Typolink to an email.
	 *
	 * Alias to asUrl
	 *
	 * If no label key is given the url is displayed as label.
	 * If the label is available but no url the label is returned
	 * without the tag. If both fails nothing is returned.
	 *
	 * @param    mixed        $emailKey key of the email field
	 * @param    mixed        $labelKey key of the label field
	 * @return    string        the linktag
	 * @see        \Spin\Lib\Link
	 * @see        asUrl()
	 */
	function asEmail($emailKey, $labelKey = NULL) {
		return $this->asUrl($emailKey, $labelKey);
	}


	/**
	 * Make an external Typolink to an url.
	 *
	 * If no label key is given the url is displayed as label.
	 * If the label is available but no url the label is returned
	 * without the tag. If both fails nothing is returned.
	 *
	 * @param    mixed        $urlKey key of the url field
	 * @param    mixed        $labelKey key of the label field
	 * @return    string        the linktag
	 * @see        tx_lib_link
	 */
	function asUrl($urlKey, $labelKey = NULL) {
		/** @var \Spin\Lib\Link $link */
		$link = GeneralUtility::makeInstance('\\Spin\\Lib\\Link');
		$link->destination($this->get($urlKey));
		if ($labelKey) {
			$link->label($this->get($labelKey), 1);
		}

		return $link->makeTag();
	}


	/**
	 * Get a formatted float value out of the internal data array.
	 *
	 * If no format paramter is provided, the function tries
	 * to find one in the configurations by using the pathKey $this->floatFormatKey.
	 *
	 * The last fallback is ',.2';
	 *
	 * <pre>
	 * Examples for 1234,123456789012:
	 * ------------------------------
	 * ',.2' =>  1,234.12              // fallback
	 * ',.3' =>  1,234.123
	 * '.2' =>  1234.12
	 * ' ,3' =>  1 234.123
	 * '.,12' =>  1.234,123456789012
	 * </pre>
	 *
	 * The decimal value at the end is the value of decimals.
	 * The char before it is the decimal point charcter.
	 * The char before it (at the beginning of any) is the thousands seperator
	 *
	 * @param    mixed        $key key of internal data array
	 * @param    string        $format format string
	 * @return    string        human readable date string
	 * @see        http://php.net/strftime
	 */
	function asFloat($key, $format = NULL) {
		if (!$format && is_object($this->controller) && is_object($this->controller->configurations)) {
			$format = $this->controller->configurations->get($this->floatFormatKey);
		}
		if (!$format) {
			$format = ',.2'; //fallback
		}
		if (preg_match('/^(\D?)(\D)(\d*)$/', $format, $matches)) {
			$thousandsSeparator = $matches[1];
			$decimalPoint = $matches[2];
			$decimalsAmount = $matches[3];
			$value = 0 + $this->get($key);

			return number_format($value, $decimalsAmount, $decimalPoint, $thousandsSeparator);
		} else {
			return false;
		}
	}


	/**
	 * Get a formatted form out of the internal data array.
	 *
	 * @param    mixed        $key key of internal data array
	 * @return    string        human readable date string
	 */
	function asForm($key) {
		return htmlspecialchars($this->get($key));
	}


	/**
	 * Get a string parsed for standard html input (parseFunc).
	 *
	 * This includes parsing of http://xxxx and mailto://xxxx to links.
	 *
	 * The second parameter has to be a pathKey for the configurator object.
	 * If it is not provided we take $this->parseFuncKey alternatively.
	 * With this parseFuncKey we query for the parseFunc setup.
	 * If no setup is found we fall back to  "< lib.parseFunc";
	 *
	 * @param    mixed        $key key of internal data
	 * @param    string        $parseFuncKey key of configurator for parseFunc setup
	 * @return    mixed        parsed string
	 */
	function asHtml($key, $parseFuncKey = '') {
		$parseFunc = false;
		if (is_object($this->controller) && is_object($this->controller->configurations)) {
			$parseFuncKey = $parseFuncKey ? $parseFuncKey : $this->parseFuncTextKey;
			$parseFunc = $this->controller->configurations->get($parseFuncKey);
		}
		if (is_array($parseFunc)) {
			$setup['parseFunc.'] = $parseFunc;
		} elseif ($parseFunc) {
			$setup['parseFunc'] = $parseFunc;
		} else {
			$setup['parseFunc'] = '< lib.parseFunc';
		}
		$setup['value'] = $this->get($key);
		$cObject = $this->findCObject();

		return $cObject->cObjGetSingle('TEXT', $setup);
	}


	/**
	 * Get an integer from the internal data array by key.
	 *
	 * @param    mixed        $key key of the internal data array
	 * @return    integer        value assigned to the key
	 */
	function asInteger($key) {
		return (integer)$this->get($key);
	}


	/**
	 * Get a raw value from the internal data array by key.
	 *
	 * Just an alias to $this->get(); to have an analogous name to printRaw();
	 *
	 * @param    mixed        $key key of the internal data array
	 * @return    mixed        array of string assigned to the key
	 * @see        get()
	 */
	function asRaw($key) {
		return $this->get($key);
	}


	/**
	 * Get a String parsed for RTE input (parseFunc_RTE).
	 *
	 * The second parameter has to be a pathKey for the configurator object.
	 * If it is not provided we take $this->parseFuncKey alternatively.
	 * With this parseFuncKey we query for the parseFunc setup.
	 * If no setup is found we fall back to  "< lib.pareseFunc_RTE";
	 *
	 * But typically use the fallback variant for this.
	 *
	 * @param    mixed        $key key of internal data
	 * @param    string        $parseFuncKey key of configurator for parseFunc setup
	 * @return    mixed        parsed string
	 */
	function asRte($key, $parseFuncKey = '') {
		$parseFunc = false;
		if (is_object($this->controller) && is_object($this->controller->configurations)) {
			$parseFuncKey = $parseFuncKey ? $parseFuncKey : $this->parseFuncRteKey;
			$parseFunc = $this->controller->configurations->get($parseFuncKey);
		}
		if (is_array($parseFunc)) {
			$setup['parseFunc.'] = $parseFunc;
		} elseif ($parseFunc) {
			$setup['parseFunc'] = $parseFunc;
		} else {
			$setup['parseFunc'] = '< lib.parseFunc_RTE'; // fallback
		}
		$setup['value'] = $this->get($key);
		$cObject = $this->findCObject();

		return $cObject->cObjGetSingle('TEXT', $setup);
	}


	/**
	 * Get a string parsed for standard text input (parseFunc).
	 *
	 * This includes HTMLSPECIALCHARS
	 * and parsing of http://xxxx and mailto://xxxx to links.
	 *
	 * Behaves identical to asHtml() but additionally escapes html special characters.
	 *
	 * @param    mixed        $key key of internal data
	 * @param    string        $parseFuncKey key of configurator for parseFunc setup
	 * @return    mixed        parsed string
	 * @see        asHtml()
	 */
	function asText($key, $parseFuncKey = '') {
		$parseFunc = false;
		if (is_object($this->controller) && is_object($this->controller->configurations)) {
			$parseFuncKey = $parseFuncKey ? $parseFuncKey : $this->parseFuncTextKey;
			$parseFunc = $this->controller->configurations->get($parseFuncKey);
		}
		if (is_array($parseFunc)) {
			$setup['parseFunc.'] = $parseFunc;
		} elseif ($parseFunc) {
			$setup['parseFunc'] = $parseFunc;
		} else {
			$setup['parseFunc'] = '< lib.parseFunc';
		}
		$setup['value'] = htmlspecialchars($this->get($key));
		$cObject = $this->findCObject();

		return $cObject->cObjGetSingle('TEXT', $setup);
	}


	/**
	 * Get a string parsed for standard text input (parseFunc).
	 *
	 * This includes HTMLSPECIALCHARS
	 * and parsing of http://xxxx and mailto://xxxx to links.
	 * Afterwards line breaks are added to keep output from text fields
	 *
	 * Behaves identical to asHtml() but additionally escapes html special characters.
	 *
	 * @param    mixed        $key key of internal data
	 * @param    string        $parseFuncKey key of configurator for parseFunc setup
	 * @return    mixed        parsed string
	 * @see        asHtml()
	 */
	function asTextField($key, $parseFuncKey = '') {
		$parseFunc = false;
		if (is_object($this->controller) && is_object($this->controller->configurations)) {
			$parseFuncKey = $parseFuncKey ? $parseFuncKey : $this->parseFuncTextKey;
			$parseFunc = $this->controller->configurations->get($parseFuncKey);
		}
		if (is_array($parseFunc)) {
			$setup['parseFunc.'] = $parseFunc;
		} elseif ($parseFunc) {
			$setup['parseFunc'] = $parseFunc;
		} else {
			$setup['parseFunc'] = '< lib.parseFunc';
		}
		$setup['value'] = nl2br(htmlspecialchars($this->get($key)));
		$cObject = $this->findCObject();

		return $cObject->cObjGetSingle('TEXT', $setup);
	}


	/**
	 * Get human readability and localized time for a timestamp out of the internal data array.
	 *
	 * If no format parameter is provided, the function tries to find one in the configurator
	 * by using the pathKey $this->timeFormatKey.
	 *
	 * @param    mixed        $key key of internal data array
	 * @param    string        $format format string
	 * @return    string        human readable date string
	 * @see        http://php.net/strftime
	 */
	function asTime($key, $format = NULL) {
		if (!$format && is_object($this->controller) && is_object($this->controller->configurations)) {
			$format = $this->controller->configurations->get($this->timeFormatKey);
		}
		if ($format) {
			return strftime($format, $this->get($key));
		} else {
			return false;
		}
	}


	/**
	 * Returns the captcha question previously generated by a captcha class.
	 *
	 * @return    string        the captcha question
	 * @see        \Spin\Lib\Captcha
	 */
	function getCaptchaQuestion() {
		if (!$this->get('_captchaQuestion')) {
			$this->_die('Please include a captcha class into the SPL chain and call createTest($id) before you can call it', __FILE__, __LINE__);
		}

		return $this->get('_captchaQuestion');
	}


	/**
	 * Returns an input field to enter the answer to the captcha question.
	 *
	 * @param    mixed        $id an id to add to the input field
	 * @return    string        typically an (x)html string
	 * @see        \Spin\Lib\Captcha
	 */
	function getCaptchaInput($id = NULL) {
		if (!$this->get('_captchaInput')) {
			$this->_die('Please include a captcha class into the SPL chain and call createTest($id) before you can call it', __FILE__, __LINE__);
		}

		return sprintf($this->get('_captchaInput'), ($id ? ' id="' . $id . '"' : ''));
	}


	/**
	 * Print a html formatted error list.
	 *
	 * @param    string        $class class name
	 * @param    string        $key key
	 * @return    void
	 */
	function getErrorList($class = 'errors', $key = '_errorList') {
		$errorList = (array)$this->get($key);
		$out = '';
		if (count($errorList)) {
			foreach ($errorList as $error) {
				$out .= '<li>' . $error['message'] . '</li>';
			}
			printf('<ul%s>%s</ul>', $class ? ' class="' . trim($class) . '"' : '', $out);
		}
	}


	/**
	 * Print hidden fields.
	 *
	 * @return    string        typically an (x)html string
	 */
	function getHiddenFields() {
		if (is_object($this->controller) && is_object($this->controller->parameters))
			return $this->controller->parameters->toHiddenFields();
		else return '';
	}


}


