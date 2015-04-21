<?php

namespace Spin\Lib\ResultBrowser;

use \Spin\Lib;
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
 * Model class of the resultbrowser
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */

class Model extends Lib\Object {

    /**
     * @var	\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
	var $cObject;

    /**
     * @var array
     */
	var $parameters = array();

    /**
     * @var int
     */
	var $pagerIndexMode;

    /**
     * @var int
     */
	var $resultsPerView;

    /**
     * @var int
     */
	var $precedingViewsCount;

    /**
     * @var int
     */
	var $totalResultCount;

    /**
     * @var int
     */
	var $succeedingViewsCount;

    /**
     * @var string
     */
	var $offsetName = '';

    /**
     * @var int
     */
	var $offset;

    /**
     * @var int
     */
	var $topFloor;

    /**
     * @var int
     */
	var $firstPrecedingFloor;

    /**
     * @var int
     */
	var $lastSucceedingFloor;

    /**
     * @var bool
     */
 	var $useCacheHash;


	function construct() {
		$this->setup();
		$this->buildPreviousView();
		$this->buildFirstView();
		$this->buildPrecedingDots();
		$this->buildPrecedingViews();
		$this->buildPreviousView();
		$this->buildCurrentView();
		$this->buildSucceedingViews();
		$this->buildSucceedingDots();
		$this->buildLastView();
		$this->buildNextView();
	}


	function setup(){
		$this->cObject = GeneralUtility::makeInstance('\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
		$this->parameters = $this->controller->parameters->getHashArray();
		$configurations = $this->controller->configurations->getHashArray();

		// The number of total results.
		$this->totalResultCount = $configurations['totalResultCount'];

		// Pager index mode: Use view numbers instead of results offset for the links.
		$this->pagerIndexMode = $configurations['pagerIndexMode'];

		// Use cache hash.
		$this->useCacheHash = $configurations['useCacheHash'];

		// The number of results per view defaults to 10.
		$this->resultsPerView = $configurations['resultsPerView'] > 0 ? (int) $configurations['resultsPerView'] : 10;

		// The number of preceding views to display before the current defaults to 3.
		$this->precedingViewsCount = $configurations['precedingViewsCount'] > 0 ? (int) $configurations['precedingViewsCount'] : 3;

		// The number of succeeding views to display after the current defaults to 3.
		$this->succeedingViewsCount = isset($configurations['succeedingViewsCount']) ? (int) $configurations['succeedingViewsCount'] : 3;

		// The name of the offset defaults to offset.
		$this->offsetName = strlen($configurations['offsetName']) ? $configurations['offsetName'] : 'offset';

		// Get offset from parameters. 
		$this->offset = (int) $this->parameters[$this->offsetName];

		// In pager index mode evaluate the view numbers back to the offset of results.
		$this->offset = $this->pagerIndexMode ? ($this->offset * $this->resultsPerView) : $this->offset;

		// The offest is never negativ.
		$this->offset = $this->offset < 0 ? 0 : $this->offset; 

		// Top floor. The last view to show. The offset is the last floor below total results.
		$this->topFloor = (floor(($this->totalResultCount - 1)/$this->resultsPerView)) * $this->resultsPerView;

		// The first preceding view to show. Never below 0.
		$offset = $this->offset - ($this->precedingViewsCount * $this->resultsPerView);
		$this->firstPrecedingFloor = $offset < 0 ? 0 : $offset;

		// The last succeeding view to show. Never above the top floor.
		$offset = $this->offset + ($this->succeedingViewsCount * $this->resultsPerView);
		$this->lastSucceedingFloor = $offset > $this->topFloor ? $this->topFloor : $offset;

	}


	function buildPreviousView() { 
		$offset = $this->offset - $this->resultsPerView;
		$this->set('previousViewUrl', $this->makeurl($offset));
		$this->set('previousViewNumber', $this->makeNumber($offset));
		$this->set('previousViewOffset', $offset);
		if($offset >= 0) {  
			$this->set('previousViewIsVisible', TRUE);
		} else {
			$this->set('previousViewIsVisible', FALSE);
		}
	}


	function buildFirstView() {
		$offset = 0;
		$this->set('firstViewUrl', $this->makeUrl($offset));
		$this->set('firstViewNumber', $this->makeNumber($offset));
		$this->set('firstViewOffset', $offset);
		if($this->firstPrecedingFloor > $offset) {
			$this->set('firstViewIsVisible', TRUE);
		} else {
			$this->set('firstViewIsVisible', FALSE);
		}
	}


	function buildPrecedingViews(){
		$array = array();
		for($offset = $this->firstPrecedingFloor; $offset < $this->offset; $offset += $this->resultsPerView) {
			$array[$offset]['url'] = $this->makeUrl($offset);
			$array[$offset]['number']	= $this->makeNumber($offset);
			$array[$offset]['offset']	= $offset;
		}
		if(count($array)) {
			$this->set('precedingViewsAreVisible', TRUE);
		} else {
			$this->set('precedingViewsAreVisible', FALSE);
		}
		$this->set('precedingViews', $array);
	}


	function buildPrecedingDots() {
		if($this->firstPrecedingFloor > $this->resultsPerView) { 
			$this->set('precedingDotsAreVisible', TRUE);
		} else {
			$this->set('precedingDotsAreVisible', FALSE);
		}
	}


	function buildCurrentView() {
		$offset = $this->offset;
		$this->set('currentViewUrl', $this->makeUrl($offset));
		$this->set('currentViewNumber', $this->makeNumber($offset));
		$this->set('currentViewOffset', $offset);
		$this->set('currentViewIsVisible', TRUE);
	}


	function buildSucceedingDots(){
		if($this->lastSucceedingFloor < ($this->topFloor - $this->resultsPerView)) {  
			$this->set('succeedingDotsAreVisible', TRUE);
		} else {
			$this->set('succeedingDotsAreVisible', FALSE);
		}
	}


	function buildSucceedingViews() {
		$array = array();
		for( $offset = $this->offset + $this->resultsPerView; $offset <= $this->lastSucceedingFloor; $offset += $this->resultsPerView) {
			$array[$offset]['url'] = $this->makeUrl($offset);
			$array[$offset]['number'] = $this->makeNumber($offset);
			$array[$offset]['offset'] = $offset;
		}
		if(count($array)) {
			$this->set('succeedingViewsAreVisible', TRUE);
		} else {
			$this->set('succeedingViewsAreVisible', FALSE);
		}
		$this->set('succeedingViews',  $array);
	}


	function buildLastView(){
		$offset = $this->topFloor;
		$this->set('lastViewUrl', $this->makeUrl($offset));
		$this->set('lastViewNumber', $this->makeNumber($offset));
		if($offset > $this->lastSucceedingFloor) {
			$this->set('lastViewIsVisible', TRUE);
		} else {
			$this->set('lastViewIsVisible', FALSE);
		}
	}


	function buildNextView(){
		$offset = $this->offset + $this->resultsPerView;
		$this->set('nextViewUrl', $this->makeUrl($offset));
		$this->set('nextViewNumber', $this->makeNumber($offset));
		$this->set('nextViewOffset', $offset);
		if($offset <= $this->topFloor) {
			$this->set('nextViewIsVisble', TRUE);
		} else {
			$this->set('nextViewIsVisble', FALSE);
		}
	}


	function makeNumber($offset) {
		return floor($offset/$this->resultsPerView) + 1;
	}


	function makeUrl($offset){
		if($this->pagerIndexMode) {  // Use view number instead of results offset.
			$offset = floor($offset/$this->resultsPerView);
		}
		$parameters = $this->parameters;
		$parameters[$this->offsetName] =  (integer) $offset;
		$conf['additionalParams'] = $this->makeUrlParameters('&' . $this->controller->getDefaultDesignator(), $parameters);
		$conf['useCacheHash'] = $this->useCacheHash;
		$conf['parameter'] = $GLOBALS['TSFE']->id;
		$conf['returnLast'] = 'url';
		$url = $this->cObject->typolink(NULL, $conf);
		return htmlspecialchars($url);
	}


	function makeUrlParameters($firstPart, $parameters){
        $out = '';
		foreach($parameters as $key => $value){
			if(is_array($value)) {
				$out .= $this->makeUrlParameters($firstPart . 	('[' . $key . ']'), $value);
			}else{
				$out .= $firstPart . ('[' . $key . ']=' . $value);
			}
		}
		return $out;
	}
}

