<?php

namespace Spin\Lib;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
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
 * This class is a wrapper for the TS object IMAGE
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2006-2007 Elmar Hinz
 *
 * LICENSE:
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */

/**
 * This class is a wrapper for the TS object IMAGE
 *
 * With this class a tag with the typical TYPO3 IMAGE functionality can be
 * generated using the lib/div object and setters style.
 *
 * Different from the original IMAGE no title tag will be generated for an image,
 * if no title text is provided. The typical behaviour of IMAGE to copy the alt text
 * is considered to be a disadvantage for accessibilty.
 *
 * This class only offers basical functionality for simple image generation. Feel free
 * to improve the funcitonality by creating inherited classes within your extension.
 *
 * <code>
 *  $imageClassName = tx_div::makeInstanceClassName('tx_lib_image');
 *  $image = new $imageClassName();
 *  $image->alt('Test image'):
 *  $image->width(340);
 *  $image->path('fileadmin/templates/test.gif');
 *  echo $image->make();
 * </code>
 *
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @package    TYPO3
 * @subpackage lib
 */
class Image {

	/**
	 * @var ContentObjectRenderer
	 */
	var $cObject;

	/**
	 * @var string
	 */
	var $heightInteger = '';

	/**
	 * @var string
	 */
	var $maxHeightInteger = '';

	/**
	 * @var string
	 */
	var $maxWidthInteger = '';

	/**
	 * @var string
	 */
	var $widthInteger = '';

	/**
	 * @var string
	 */
	var $altString = '';

	/**
	 * @var string
	 */
	var $pathString = '';

	/*
	 * @var string
	 */
	var $titleString = '';


	/**
	 * constructor
	 */
	function __construct() {
		$this->Image();
	}


	/**
	 * constructor
	 */
	function Image() {
	}

	// -------------------------------------------------------------------------------------
	// Setters
	// -------------------------------------------------------------------------------------

	/**php
	 * Set the alt text.
	 *
	 * If no alt tag is given at all, an empty alt tag will be generated.
	 *
	 * @param    string $string alt text
	 * @return $this
	 */
	function alt($string) {
		$this->altString = $string;

		return $this;
	}


	/**
	 * Set the image height.
	 *
	 * @param    integer $integer image height
	 * @return $this
	 */
	function height($integer) {
		$this->heightInteger = $integer;

		return $this;
	}


	/**
	 * Set the maximal height.
	 *
	 * @param    integer $integer maximal height
	 * @return $this
	 */
	function maxHeight($integer) {
		$this->maxHeightInteger = $integer;

		return $this;
	}


	/**
	 * Set the maximal width.
	 *
	 * @param    integer $integer maximal width
	 * @return $this
	 */
	function maxWidth($integer) {
		$this->maxWidthInteger = $integer;

		return $this;
	}


	/**
	 * Set the image path.
	 *
	 * @param    string $string image path
	 * @return $this
	 */
	function path($string) {
		$this->pathString = $string;

		return $this;
	}


	/**
	 * Set the title text.
	 *
	 * If no tilte is provided at all, no title attribute will be generated.
	 * This differs from the typical behaviour of TS Object IMAGE.
	 *
	 * @param    string $string title text
	 * @return $this
	 */
	function title($string) {
		$this->titleString = $string;

		return $this;
	}


	/**
	 * Set the  width.
	 *
	 * @param    integer $integer width
	 * @return $this
	 */
	function width($integer) {
		$this->widthInteger = $integer;

		return $this;
	}

	// -------------------------------------------------------------------------------------
	// Getters
	// -------------------------------------------------------------------------------------

	/**
	 * Render the image.
	 *
	 * @return    string        image tag
	 */
	function make() {
		return $this->_render();
	}

	// -------------------------------------------------------------------------------------
	// Private functions
	// -------------------------------------------------------------------------------------


	/**
	 * Generates the HTML code for the image using IMAGE() function of tslib_cObj.
	 *
	 * @return    string        <img>-HTML code
	 * @access    protected
	 */
	function _render() {
		$setup = '
			file = %s
			file.width = %s
			file.height = %s
			file.maxW = %s
			file.maxH = %s
			altText = %s
			titleText = %s
		';
		$setup = sprintf(
				$setup,
				$this->pathString,
				$this->widthInteger,
				$this->heightInteger,
				$this->maxWidthInteger,
				$this->maxHeightInteger,
				$this->altString,
				$this->titleString
		);
//		require_once(PATH_t3lib . 'class.t3lib_tsparser.php');
//		$TSparserObject = t3lib_div::makeInstance('t3lib_tsparser');
		/** @var \TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser $TSparserObject */
		$TSparserObject = GeneralUtility::makeInstance('\\TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
		$TSparserObject->parse($setup);
		$setup = $TSparserObject->setup;
		$cObject = $this->_findCObject();
		$image = $cObject->cObjGetSingle('IMAGE', $setup);

		// The default behaviour of the IMAGE  is to make an empty alt altribut if alt is not given. That is fine.
		// If title is not given it takes the alt text for the title tag. That is not fine.
		// We need to strip the title tag if it is empty:

		if (!$this->titleString) {
			$pattern = '/title\w*=\w*"[^"]*"/';
			$image = preg_replace($pattern, '', $image);
		}

		return $image;
	}


	/**
	 * Returns a valid tslib_cObj.
	 *
	 * Implements Singleton-Pattern.
	 *
	 * @return    ContentObjectRenderer        a tslib_CObj
	 * @access    protected
	 */
	function _findCObject() {
		if (!$this->cObject) {
			$this->cObject = GeneralUtility::makeInstance
					('\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
		}

		return $this->cObject;
	}

}

