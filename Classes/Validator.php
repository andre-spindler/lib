<?php

namespace Spin\Lib;


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
 * A class to validate key => value pairs against a set of rules.
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */


class Validator extends Object {

	var $pathToRules;
	var $errors;

	/**
	 * Set the namespace of rules to be used for validation.
	 *
	 * @param	string		validation rules namespace
	 * @return	void
	 */
	function useRules($path = 'validationRules.') {
		$this->pathToRules = $path;
	}

	/**
	 * Validates the given object against the specified rules.
	 *
	 * @param	object		object with key=>value pairs
	 * @return	void
	 */
	function validate($object = null) {
		if(is_object($object)) {
			$this->setArray($object);
		}
		if($this->pathToRules) {
			$this->_validateByRules();
		}
		$this->set('_errorList', $this->errors);
		$this->set('_errorCount', count($this->errors));
	}

	/**
	 * Check whether there were failures during validation or not.
	 *
	 * @return	boolean		true if there are errors, false otherwise
	 */
	function ok() {
		return count($this->errors) == 0;
	}

	/**
	 * Do the actual validation.
	 *
	 * @return	void
	 * @access	private
	 */
	function _validateByRules() {
		foreach($this->controller->configurations->get($this->pathToRules) as $rule) {
			if(!preg_match($rule['pattern'], $this->get($rule['field']))) {
				$this->errors[] = array_merge(array('.type' => 'rule'), $rule);
			}
		}
	}

}