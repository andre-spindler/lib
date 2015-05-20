<?php

namespace Spin\Lib;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Utility\ArrayUtility;
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
 * This class is a wrapper around tslib_cObj::typoLink
 *
 * It is not a full implementation of typolink functionality
 * but targeted to the day-to-day requirements. The idea is to provide
 * an simple to use object orientated interface as an alternative to the
 * typolink functions of pi_base.
 *
 * Depends on: the TS link function
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class Link {

	/**
	 * setting attributes for the tag in general
	 *
	 * @var array
	 */
	var $tagAttributes = array();

	/**
	 * tags class attribute
	 *
	 * @var string
	 */
	var $classString = '';

	/**
	 * tags id attribute
	 *
	 * @var string
	 */
	var $idString = '';

	/**
	 * instance of tslib_cObj
	 *
	 * @var ContentObjectRenderer
	 */
	var $cObject = NULL;

	/**
	 * page id, alias, external link, etc.
	 *
	 * @var string
	 */
	var $destination = '';

	/**
	 * tags label
	 *
	 * @var string
	 */
	var $labelString = '';

	/**
	 * is the label already HSC?
	 *
	 * @var bool
	 */
	var $labelHasAlreadyHtmlSpecialChars = false;

	/**
	 * don't make a cHash
	 *
	 * @var bool
	 */
	var $noCacheBoolean = false;

	/**
	 * add a no_cache=1 parameter
	 *
	 * @var bool
	 */
	var $noHashBoolean = false;

	/**
	 * parameters overruled by $parameters
	 *
	 * @var array
	 */
	var $overruledParameters = array();

	/**
	 * parameters of the link
	 *
	 * @var array
	 */
	var $parameters = array();

	/**
	 * parameter array name (prefixId) as controller namespace
	 *
	 * @var string
	 */
	var $designatorString = '';

	/**
	 * section anchor as url target
	 *
	 * @var string
	 */
	var $anchorString = '';

	/**
	 * tags target attribute
	 *
	 * @var string
	 */
	var $targetString = '';

	/**
	 * external target defaults to new window
	 *
	 * @var string
	 */
	var $externalTargetString = '_blank';

	/**
	 * tags title attribute
	 *
	 * @var string
	 */
	var $titleString = '';

	/**
	 * is title attribute already HSC?
	 *
	 * @var bool
	 */
	var $titleHasAlreadyHtmlSpecialChars = false;

	/**
	 * is link to be created as absolute?
	 *
	 * @var bool
	 */
	var $makeAbsolute = false;


	// -------------------------------------------------------------------------------------
	// Constructor
	// -------------------------------------------------------------------------------------


	/**
	 * constructor
	 *
	 * @param string $cObjectClass
	 */
	function __construct($cObjectClass = '\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer') {
		$this->Link($cObjectClass);
	}


	/**
	 * Construct a link object
	 *
	 * By default this object wraps tslib_cObj::typolink();
	 * The $cObjectClass parameter can be used to provide a mock object
	 * for unit tests.
	 *
	 * @param    string        $cObjectClass mock object for testing purpuses
	 * @return    void
	 */
	function Link($cObjectClass = '\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer') {
		$this->cObject = GeneralUtility::makeInstance($cObjectClass);
	}


	// -------------------------------------------------------------------------------------
	// Setters
	// -------------------------------------------------------------------------------------


	/**
	 * Set the section anchor of the url
	 *
	 * Anchor of page as url target.
	 *
	 * @param    string        $anchorString the anchor
	 * @return    Link        self
	 */
	function anchor($anchorString) {
		$this->anchorString = $anchorString;

		return $this;
	}


	/**
	 * Set the designator (parameter array name) as controler namespace
	 *
	 * Put the parameters into this array.
	 * <samp>Example: &tx_example[parameterName]=parameterValue</samp>
	 * tx_example is the designator, parameterName is the key,
	 * pararmeterValue is the value of one array element.
	 *
	 * @param    string        $designatorString parameter array name
	 * @return    Link        self
	 */
	function designator($designatorString) {
		$this->designatorString = $designatorString;

		return $this;
	}


	/**
	 * Set the id attribute of the tag
	 *
	 * @param    string        $idString id attribute
	 * @return    Link        self
	 */
	function idAttribute($idString) {
		$this->idString = $idString;

		return $this;
	}


	/**
	 * Set the class attribute of the tag
	 *
	 * @param    string        $classString class name
	 * @return    Link        self
	 */
	function classAttribute($classString) {
		$this->classString = $classString;

		return $this;
	}


	/**
	 * Set the links destination
	 *
	 * @param    mixed        $destination pageId, page alias, external url, etc.
	 * @return    Link        self
	 * @see        TSref => typolink => parameter
	 * @see        ContentObjectRenderer::typoLink()
	 */
	function destination($destination) {
		$this->destination = $destination;

		return $this;
	}


	/**
	 * Add no_cache=1 and disable the cHash parameter
	 *
	 * @return    Link        self
	 */
	function noCache() {
		$this->noCacheBoolean = true;

		return $this;
	}


	/**
	 * Disable the cHash parameter
	 *
	 * @return    Link        self
	 */
	function noHash() {
		$this->noHashBoolean = true;

		return $this;
	}


	/**
	 * Set the links label
	 *
	 * By default the label will be parsed through htmlspecialchars().
	 *
	 * @param    string        $labelString the label
	 * @param    boolean        $hasAlreadyHtmlSpecialChars if true don't parse through htmlspecialchars()
	 * @return    Link        self
	 */
	function label($labelString, $hasAlreadyHtmlSpecialChars = false) {
		$this->labelString = $labelString;
		$this->labelHasAlreadyHtmlSpecialChars = $hasAlreadyHtmlSpecialChars;

		return $this;
	}


	/**
	 * Set array of parameters to be overruled by parameters
	 *
	 * The parameters will create a common array with the name $this->designatorString.
	 * <samp>Example: &tx_example[parameterName]=parameterValue</samp>
	 * tx_example is the designator, parameterName is the key,
	 * pararmeterValue is the value of one array element.
	 *
	 * Usually you set the incomming piVars here you wan't to forward.
	 * Like in tslib_pibase::pi_linkTP_keepPIvars the element DATA is unset during processing.
	 *
	 * @param    mixed        $overruledParameters parameters
	 * @return    Link        self
	 */
	function overruled($overruledParameters = array()) {
		if (is_object($overruledParameters)) {
			$overruledParameters = $overruledParameters->getArrayCopy();
		}
		$this->overruledParameters = $overruledParameters;

		return $this;
	}


	/**
	 * Set array of new parameters to add to the link url
	 *
	 * The parameters will create a common array with the name $this->designatorString.
	 * <samp>Example: &tx_example[parameterName]=parameterValue</samp>
	 * tx_example is the designator, parameterName is the key,
	 * pararmeterValue is the value of one array element.
	 *
	 * This parameters overrule parameters in $this->baseParameters.
	 *
	 * @param    mixed        $parameters parameters
	 * @return    Link        self
	 */
	function parameters($parameters = array()) {
		if (is_object($parameters)) {
			$parameters = $parameters->getArrayCopy();
		}
		$this->parameters = $parameters;

		return $this;
	}


	/**
	 * Set the attributes of the tag
	 *
	 * This is a general approach to set tag attributes by an array hash.
	 *
	 * @see    classAttribute()
	 * @see    titleAttribute()
	 * @see    targetAttribute()
	 *
	 * @param    array        $tagAttributes key value pairs
	 * @return    Link        self
	 */
	function attributes($tagAttributes = array()) {
		$this->tagAttributes = $tagAttributes;

		return $this;
	}


	/**
	 * Set target attribute of the tag
	 * A shortcut for the targetAttribute() function.
	 *
	 * @see    targetAttribute()
	 *
	 * @param    string        $targetString target attribute
	 * @return    Link        self
	 */
	function target($targetString) {
		$this->targetAttribute($targetString);

		return $this;
	}


	/**
	 * Set target attribute of the tag
	 *
	 * @param    string        $targetString target attribute
	 * @return    Link        self
	 */
	function targetAttribute($targetString) {
		$this->targetString = $targetString;

		return $this;
	}


	/**
	 * Set external target attribute of the tag
	 * Defaults to _blank
	 *
	 * @param    string        $targetString external target attribute
	 * @return    Link        self
	 */
	function externalTargetAttribute($targetString) {
		$this->externalTargetString = $targetString;

		return $this;
	}


	/**
	 * Set title attribute of the tag
	 * A shortcut for the titleAttribute() function.
	 *
	 * @see    titleAttribute()
	 *
	 * @param    string        $titleString title attribute
	 * @param    boolean        $hasAlreadyHtmlSpecialChars if true don't apply htmlspecialchars() again
	 * @return    Link        self
	 */
	function title($titleString, $hasAlreadyHtmlSpecialChars = false) {
		$this->titleAttribute($titleString, $hasAlreadyHtmlSpecialChars);

		return $this;
	}


	/**
	 * Set title attribute of the tag
	 *
	 * @param    string        $titleString title attribute
	 * @param    boolean       $hasAlreadyHtmlSpecialChars  if true don't apply htmlspecialchars() again
	 * @return    Link        self
	 */
	function titleAttribute($titleString, $hasAlreadyHtmlSpecialChars = false) {
		$this->titleString = $titleString;
		$this->titleHasAlreadyHtmlSpecialChars = $hasAlreadyHtmlSpecialChars;

		return $this;
	}


	/**
	 * Generate absolute links
	 *
	 * @param   boolean     $absolute
	 * @return  Link        self
	 */
	function makeAbsolute($absolute) {
		$this->makeAbsolute = $absolute;

		return $this;
	}

	// -------------------------------------------------------------------------------------
	// Getters
	// -------------------------------------------------------------------------------------


	/**
	 * Return the link as tag
	 *
	 * @return    string        the link tag
	 */
	function makeTag() {
		return $this->cObject->typolink(
				$this->_makeLabel(),
				$this->_makeConfig('tag')
		);
	}


	/**
	 * Make the label for the link
	 *
	 * @return    string        the label
	 * @access    private
	 */
	function _makeLabel() {
		return ($this->labelHasAlreadyHtmlSpecialChars) ? $this->labelString
				: htmlspecialchars($this->labelString);
	}


	/**
	 * Make the full configuration for the typolink function
	 *
	 * @param    string $type : tag oder url
	 * @return    array        the configuration
	 * @access    private
	 */
	function _makeConfig($type) {
		$conf = array();
		$this->parameters = is_array($this->parameters) ?
				$this->parameters : array();
		$this->overruledParameters = is_array($this->overruledParameters) ?
				$this->overruledParameters : array();
		unset($this->overruledParameters['DATA']);
		$parameters = $this->overruledParameters;
		ArrayUtility::mergeRecursiveWithOverrule($parameters, $this->parameters);
		foreach ((array)$parameters as $key => $value) {
			if (!is_array($value)) { // TODO handle arrays
				if ($this->designatorString) {
					$conf['additionalParams']
							.= '&' . rawurlencode($this->designatorString . '[' . $key . ']') . '=' . rawurlencode($value);
				} else {
					$conf['additionalParams'] .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
				}
			}
		}
		if ($this->noHashBoolean) {
			$conf['useCacheHash'] = 0;
		} else {
			$conf['useCacheHash'] = 1;
		}
		if ($this->noCacheBoolean) {
			$conf['no_cache'] = 1;
			$conf['useCacheHash'] = 0;
		} else {
			$conf['no_cache'] = 0;
		}
		if ($this->destination !== '')
			$conf['parameter'] = $this->destination;
		if ($type == 'url') {
			$conf['returnLast'] = 'url';
		}
		if ($this->anchorString) {
			$conf['section'] = $this->anchorString;
		}
		if ($this->targetString) {
			$conf['target'] = $this->targetString;
		}
		if ($this->externalTargetString) {
			$conf['extTarget'] = $this->externalTargetString;
		}
		if ($this->classString) {
			$conf['ATagParams'] .= 'class="' . $this->classString . '" ';
		}
		if ($this->idString) {
			$conf['ATagParams'] .= 'id="' . $this->idString . '" ';
		}
		if ($this->titleString) {
			$title = ($this->titleHasAlreadyHtmlSpecialChars) ? $this->titleString
					: htmlspecialchars($this->titleString);
			$conf['ATagParams'] .= 'title="' . $title . '" ';
		}
		if (is_array($this->tagAttributes)
				&& (count($this->tagAttributes) > 0)
		) {
			foreach ($this->tagAttributes as $key => $value) {
				$conf['ATagParams'] .= ' ' . $key . '="' . htmlspecialchars($value) . '" ';
			}
		}
		if ($this->makeAbsolute) {
			$conf['forceAbsoluteUrl'] = 1;
		} else {
			$conf['forceAbsoluteUrl'] = 0;
		}

		return $conf;
	}


	// -------------------------------------------------------------------------------------
	// Private functions
	// -------------------------------------------------------------------------------------


	/**
	 * Return the link as url
	 *
	 * @param    boolean        $applyHtmlSpecialChars set to true to run htmlspecialchars() on generated url
	 * @return    string        the link url
	 */
	function makeUrl($applyHtmlSpecialChars = true) {
		$url = $this->cObject->typolink(NULL, $this->_makeConfig('url'));

		return $applyHtmlSpecialChars ? htmlspecialchars($url) : $url;
	}


	/**
	 * Redirect the page to the url
	 *
	 * @return    void
	 */
	function redirect() {
		session_write_close();
		header('Location: ' . GeneralUtility::getIndpEnv('TYPO3_REQUEST_DIR')
				. $this->cObject->typolink(NULL, $this->_makeConfig('url')));
		exit();
	}


}

