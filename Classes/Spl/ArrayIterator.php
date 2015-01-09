<?php

namespace Spin\Lib\Spl;

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
 * Implementation of the SPL class ArrayIterator
 *
 * This class would implement the interfaces: SeekableIterator, ArrayAccess, Countable
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class ArrayIterator extends ArrayObject {


	/**
	 * @var bool
	 */
	var $valid = false;


	/**
	 * Returns the current element in the iterated array.
	 *
	 * @return    mixed        the current element
	 */
	function current() {
		return current($this->array);
	}


	/**
	 * Returns the key of the current element in array.
	 *
	 * @return    mixed        the key of the current element
	 */
	function key() {
		return key($this->array);
	}


	/**
	 * Moves the iterator to next element in array.
	 *
	 * @return    boolean        true if there is a next element, false otherwise
	 */
	function next() {
		$this->valid = (false !== next($this->array));
	}


	/**
	 * Resets the iterator to the first element of array.
	 *
	 * @return    boolean        true if the array is not empty, false otherwise
	 */
	function rewind() {
		$this->valid = (false !== reset($this->array));
	}


	/**
	 * Returns the element of array at index $index.
	 *
	 * @param    integer        $index the position of the requested element in array
	 * @return    mixed        an array element
	 */
	function seek($index) {
		return $this->array[$index];
	}


	/**
	 * Returns the actual state of this iterator.
	 *
	 * @return    boolean        true if iterator is valid, false otherwise
	 */
	function valid() {
		return $this->valid;
	}


}
