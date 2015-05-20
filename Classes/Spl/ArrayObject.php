<?php

namespace Spin\Lib\Spl;

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
 * Implementation of the SPL class ArrayObject
 *
 * This class would implement the interfaces: IteratorAggregate, ArrayAccess, Countable
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class ArrayObject {


	/**
	 * data
	 *
	 * @var array
	 */
	var $array = array();

	/**
	 * iterator class name
	 *
	 * @var string
	 */
	var $iteratorClass = '';

	/**
	 * @var int
	 */
	var $flags = 0;


	/**
	 * constructor
	 *
	 * @param array $array
	 * @param int $flags
	 * @param string $iteratorClass
	 */
	public function __construct($array = array(), $flags = 0, $iteratorClass = '\\Spin\\Lib\\Spl\\ArrayIterator') {
		$this->ArrayObject($array, $flags, $iteratorClass);
	}


	/**
	 * Constructs a ArrayObject using the given arguments.
	 *
	 * @todo    flags is currently useless, specify with flags are used for
	 *            and which are available.
	 *
	 * @param    array        $array the array this object should handle
	 * @param    integer      $flags some flags
	 * @param    string       $iteratorClass class name of a iterator class
	 */
	public function ArrayObject($array = array(), $flags = 0, $iteratorClass = '\\Spin\\Lib\\Spl\\ArrayIterator') {
		$this->_setArray($array);
		$this->flags = $flags;
		$this->iteratorClass = $iteratorClass;
	}


	/**
	 * Sets the data of argument array as new array handled by this object.
	 *
	 * @param    mixed            $array the new array
	 * @access    private
	 */
	function _setArray($array) {
		if (is_object($array)) {
			$this->array = $array->getArrayCopy();
		} elseif (is_array($array)) {
			$this->array = $array;
		} else {
			$this->array = array();
		}
		reset($this->array);
	}


	/**
	 * Appends the given value as element to this array.
	 *
	 * @param    mixed        $value value to append
	 */
	public function append($value) {
		$this->array[] = $value;
	}


	/**
	 * Sorts this array using the asort() function of PHP.
	 */
	public function asort() {
		asort($this->array);
	}


	/**
	 * Counts the elements in the array.
	 *
	 * @return    integer        number of elements
	 */
	public function count() {
		return count($this->array);
	}


	/**
	 * Replaces the current array handled by this object with the new one
	 * given as argument.
	 *
	 * @param    array        $array the new array to be set
	 */
	public function exchangeArray($array) {
		$this->_setArray($array);
	}


	/**
	 * Returns a copy of the array handled by this object.
	 *
	 * @return    array        a copy of the array
	 */
	public function getArrayCopy() {
		return $this->array;
	}


	/**
	 * Returns the flags associated with this object.
	 *
	 * @return    integer        the flags
	 */
	public function getFlags() {
		return $this->flags;
	}


	/**
	 * Sets the flags.
	 *
	 * @param    integer        $flags the flags
	 */
	function setFlags($flags) {
		$this->flags = $flags;
	}


	/**
	 * Returns a new iterator object for this array.
	 *
	 * @return    object        the new iterator
	 */
	public function getIterator() {
		$iteratorClass = $this->iteratorClass;

		return GeneralUtility::makeInstance($iteratorClass, $this->array);
	}


	/**
	 * Returns the class name of the iterator associated with this object.
	 *
	 * @return    string        iterator class name
	 */
	function getIteratorClass() {
		return $this->iteratorClass;
	}


	/**
	 * Set the name of the iterator class to the one given as argument.
	 *
	 * @param    string        $iteratorClass name of iterator class
	 */
	function setIteratorClass($iteratorClass) {
		$this->iteratorClass = $iteratorClass;
	}


	/**
	 * Sorts this array using the ksort() function of PHP.
	 */
	function ksort() {
		ksort($this->array);
	}


	/**
	 * Sorts this array using the natcasesort() function of PHP.
	 */
	function natcasesort() {
		natcasesort($this->array);
	}


	/**
	 * Sorts this array using the natsort() function of PHP.
	 */
	function natsort() {
		natsort($this->array);
	}


	/**
	 * Tests if an element exists at the given offset.
	 *
	 * @param    integer        $index array offset to test
	 * @return    boolean        true if element exists, false otherwise
	 */
	function offsetExists($index) {
		return isset($this->array[$index]);
	}


	/**
	 * Returns the element at the given offset.
	 *
	 * @param    integer        $index the index of the element to be returned
	 * @return    mixed        the element at given index
	 */
	function offsetGet($index) {
		return $this->array[$index];
	}


	/**
	 * Writes a value to a given offset in the array.
	 *
	 * @param    integer        $index the offset to write to
	 * @param    mixed        $newval the new value
	 */
	function offsetSet($index, $newval) {
		$this->array[$index] = $newval;
	}


	/**
	 * Unsets the element at the given offset.
	 *
	 * @param    integer        $index position of array to unset
	 */
	function offsetUnset($index) {
		unset($this->array[$index]);
	}


	/**
	 * Sorts this array using the uasort() function of PHP.
	 *
	 * @param    callback        $userFunction a function used as callback for sorting
	 */
	function uasort($userFunction) {
		uasort($this->array, $userFunction);
	}


	/**
	 * Sorts this array using the uksort() function of PHP.
	 *
	 * @param    callback        $userFunction a function used as callback for sorting
	 */
	function uksort($userFunction) {
		uksort($this->array, $userFunction);
	}


}
