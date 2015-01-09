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
 * Transport and deliver the request parameters.
 *
 * Member of the central quad: $controller, $parameters, $configurations, $context.    <br>
 * Address it from everywhere as: $this->controller->parameters
 *
 * All request parameters should be accessed from all other objects by a
 * $parameters object. Either use this class directly or as parent for your own
 * inherited class.
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class Parameters extends Object {


	/**
	 * constructor
	 *
	 * @param Controller $controller
	 */
	function __construct(Controller $controller = NULL) {
		$this->Parameters($controller);
	}


	/**
	 * Contructs a new Parameters object associated with the given controller
	 *
	 * The controller has to be set in a second step.
	 *
	 * @param        Controller $controller
	 * @return        void
	 */
	function Parameters(Controller $controller = NULL) {
		parent::Object($controller);
		if (is_object($controller) && is_subclass_of($controller, '\\Spin\\Lib\\Controller')) {
			$this->setArray(GeneralUtility::_GPmerged($controller->getDesignator()));
		}
		// Initialize the cHash system if there are parameters available
//		if ($GLOBALS['TSFE'] && !$GLOBALS['TSFE']->no_cache && $this->count()) {
//			$GLOBALS['TSFE']->reqCHash();
//		}
	}


	/**
	 * Returns a string representation of this object where all parameters are
	 * encapsulated into HTML input fields of type="hidden".
	 *
	 * @return        string        HTML code
	 */
	function toHiddenFields() {
		$out = '';
		for ($this->rewind(); $this->valid(); $this->next()) {
			if (!is_array($this->current())) { // TODO: use also arrays
				$out .= sprintf('%s<input type="hidden" name="%s[%s]" value="%s">', chr(10),
						$this->getDesignator(), $this->key(), htmlspecialchars($this->current()));
			}
		}

		return $out;
	}


}

