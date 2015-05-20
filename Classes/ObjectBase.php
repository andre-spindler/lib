<?php

namespace Spin\Lib;

use Spin\Div\TxDiv;
use Spin\Lib\Spl;
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
 * Parent class for Object
 *
 * <b>Don't use this class directly. Always use Object.</b>
 * <b>Please also see Object!!!</b>
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
abstract class ObjectBase extends SelfAwareness {


	/**
	 * @var \Spin\Lib\Spl\ArrayIterator
	 */
	var $_iterator;


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	public function __construct($parameter1 = NULL, $parameter2 = NULL) {
		$this->ObjectBase($parameter1, $parameter2);
	}


	/**
	 * Constructor of the data object
	 *
	 * You can set the controller by one of the 2 parameters.
	 * You can set the data by one of the 2 prameters. Order doesn't matter.
	 *
	 * If you don't set the controller in the constructor you MUST set it by one of the functions:
	 * $this->controller($controller), $this->setController($controller);
	 *
	 * @param    mixed        $parameter1 controller or data array or data object
	 * @param    mixed        $parameter2 controller or data array or data object
	 * @return    void
	 */
	public function ObjectBase($parameter1 = NULL, $parameter2 = NULL) {
		$this->_iterator = GeneralUtility::makeInstance('\\Spin\\Lib\\Spl\\ArrayIterator');
		if (method_exists($this, 'preset')) {
			$this->preset();
		}
		if (is_object($parameter1) && is_subclass_of($parameter1, '\\Spin\\Lib\\Controller')) {
			$this->controller = & $parameter1;
		} elseif (isset($parameter1)) {
			$this->overwriteArray($parameter1);
		}
		if (is_object($parameter2) && is_subclass_of($parameter2, '\\Spin\\Lib\\Controller')) {
			$this->controller = & $parameter2;
		} elseif (isset($parameter2)) {
			$this->overwriteArray($parameter2);
		}
		if (method_exists($this, 'construct')) {
			$this->construct();
		}
	}


	// -------------------------------------------------------------------------------------
	// Interface to ArrayObject
	// -------------------------------------------------------------------------------------


	/**
	 * Overwrite some of the internal array values
	 *
	 * Overwrite a selection of the internal values by providing new ones
	 * in form of a data structure of the tx_div hash family.
	 *
	 * @param    mixed        $hashData hash array, SPL object or hash string ( i.e. "key1 : value1, key2 : valu2,
	 * ... ")
	 * @param    string        $splitCharacters possible split charaters in case the first parameter is a hash string
	 * @return    void
	 * @see        TxDiv::toHashArray()
	 */
	function overwriteArray($hashData, $splitCharacters = ',;:\s') {
		$array = TxDiv::toHashArray($hashData, $splitCharacters);
		foreach ((array)$array as $key => $value) {
			$this->set($key, $value);
		}
	}


	/**
	 * Assign a value to a key
	 *
	 * It's just a convenient way to use the offsetSet() function from tx_lib_spl_arrayObject.
	 *
	 * @param    mixed        $key key
	 * @param    mixed        $value value
	 * @return    void
	 * @see        Spin\Lib\Spl\ArrayObject::offsetSet()
	 */
	function set($key, $value) {
		$this->offsetSet($key, $value);
	}


	/**
	 * Writes a value to a given offset in the array.
	 *
	 * @param    integer        $index the offset to write to
	 * @param    mixed        $newval the new value
	 */
	function offsetSet($index, $newval) {
		$this->_iterator->offsetSet($index, $newval);
	}


	/**
	 * Sorts this array using the asort() function of PHP.
	 */
	function asort() {
		$this->_iterator->asort();
	}


	/**
	 * Returns the flags associated with this object.
	 *
	 * @return    integer        the flags
	 */
	function getFlags() {
		return $this->_iterator->getFlags();
	}


	/**
	 * Returns a new iterator object for this array.
	 *
	 * @return    object        the new iterator
	 */
	function getIterator() {
		return $this->_iterator->getIterator();
	}


	/**
	 * Returns the class name of the iterator associated with this object.
	 *
	 * @return    string        iterator class name
	 */
	function getIteratorClass() {
		return $this->_iterator->getIteratorClass();
	}


	/**
	 * Sorts this array using the ksort() function of PHP.
	 */
	function ksort() {
		$this->_iterator->ksort();
	}


	/**
	 * Sorts this array using the natcasesort() function of PHP.
	 */
	function natcasesort() {
		$this->_iterator->natcasesort();
	}


	/**
	 * Sorts this array using the natsort() function of PHP.
	 */
	function natsort() {
		$this->_iterator->natsort();
	}


	/**
	 * Tests if an element exists at the given offset.
	 *
	 * @param    integer        $index array offset to test
	 * @return    boolean        true if element exists, false otherwise
	 */
	function offsetExists($index) {
		return $this->_iterator->offsetExists($index);
	}


	/**
	 * Unsets the element at the given offset.
	 *
	 * @param    integer        $index position of array to unset
	 */
	function offsetUnset($index) {
		$this->_iterator->offsetUnset($index);
	}


	/**
	 * Sets the flags.
	 *
	 * @param    integer        $flags the flags
	 */
	function setFlags($flags) {
		$this->_iterator->setFlags($flags);
	}


	/**
	 * Set the name of the iterator class to the one given as argument.
	 *
	 * @param    string        $iteratorClass name of iterator class
	 */
	function setIteratorClass($iteratorClass) {
		$this->_iterator->setIteratorClass($iteratorClass);
	}


	/**
	 * Sorts this array using the uasort() function of PHP.
	 *
	 * @param    callback        $userFunction a function used as callback for sorting
	 */
	function uasort($userFunction) {
		$this->_iterator->uasort($userFunction);
	}


	/**
	 * Sorts this array using the uksort() function of PHP.
	 *
	 * @param    callback        $userFunction a function used as callback for sorting
	 */
	function uksort($userFunction) {
		$this->_iterator->uksort($userFunction);
	}


	/**
	 * Returns the element of array at index $index.
	 *
	 * @param    integer        $index the position of the requested element in array
	 * @return    mixed        an array element
	 */
	function seek($index) {
		return $this->_iterator->seek($index);
	}


	/**
	 * Import the data as an object containing a list of hash objects
	 *
	 * Takes a list array or list object of hash data as first argument
	 * and a class (SPL type) as second argument. For each of the hash
	 * data an object of that class is created and appended to the
	 * internal array.
	 *
	 * @param    \Spin\Lib\Object        $objectList the data object list (i.e. from the model)
	 * @param    string        $entryClassName classname of output entries, defaults to \Spin\Lib\Object
	 * @return    void
	 */
	function asObjectOfObjects(Object $objectList, $entryClassName = '\\Spin\\Lib\\Object') {
		$this->checkController(__FILE__, __LINE__);
//		$entryClassName = TxDiv::makeInstanceClassName($entryClassName);
//		$this->clear();
//		for($objectList->rewind(); $objectList->valid(); $objectList->next()) {
//			$this->append(new $entryClassName($this->controller, tx_div::toHashArray($objectList->current())));
//		}
		$this->clear();
		for ($objectList->rewind(); $objectList->valid(); $objectList->next()) {
			$this->append(GeneralUtility::makeInstance($entryClassName, $this->controller, TxDiv::toHashArray($objectList->current())));
		}
	}


	/**
	 * Check presence of the controller
	 *
	 * @param    string        $file set the __FILE__ constant
	 * @param    string        $line set the __LINE__ constant
	 * @return    \Spin\Lib\Controller controller
	 */
	function checkController($file, $line) {
		if (!is_object($this->controller))
			$this->_die('Missing the controller.', $file, $line);

		return $this->controller;
	}


	// -------------------------------------------------------------------------------------
	// Interface to ArrayIterator
	// -------------------------------------------------------------------------------------


	/**
	 * Empty the object
	 *
	 * Clear the objects array.
	 *
	 * @return    void
	 */
	function clear() {
		$this->exchangeArray(array());
	}


	/**
	 * Replaces the current array handled by this object with the new one
	 * given as argument.
	 *
	 * @param    array        $array the new array to be set
	 */
	function exchangeArray($array) {
		$this->_iterator->exchangeArray($array);
	}


	/**
	 * Resets the iterator to the first element of array.
	 *
	 * @return    boolean        true if the array is not empty, false otherwise
	 */
	function rewind() {
		$this->_iterator->rewind();
	}


	/**
	 * Returns the actual state of this iterator.
	 *
	 * @return    boolean        true if iterator is valid, false otherwise
	 */
	function valid() {
		return $this->_iterator->valid();
	}


	/**
	 * Moves the iterator to next element in array.
	 *
	 * @return    boolean        true if there is a next element, false otherwise
	 */
	function next() {
		$this->_iterator->next();
	}


	/**
	 * Appends the given value as element to this array.
	 *
	 * @param    mixed        $value value to append
	 */
	function append($value) {
		$this->_iterator->append($value);
	}


	// -------------------------------------------------------------------------------------
	// Setters
	// -------------------------------------------------------------------------------------


	/**
	 * Returns the current element in the iterated array.
	 *
	 * @return    mixed        the current element
	 */
	function current() {
		return $this->_iterator->current();
	}


	/**
	 * Convert the internal elmements to objects of the given class name
	 *
	 * All (hash) elements of the internal array are transformed to objects of
	 * the class given as parameter.
	 *
	 * By default the function tx_div::makeInstanceClassName() is applied. That means:
	 *
	 * - The file is loaded automatically.
	 * - XCLASS is used if available.
	 *
	 * @param  string   $entryClassName Class name for the internal elements.
	 * @param  boolean  $callMakeInstanceClassName Yes, apply tx_div:makeInstanceClassName().
	 * @return void
	 * @see    tx_div::makeInstanceClassName()
	 */
	function castElements($entryClassName = '\\Spin\\Lib\\Object', $callMakeInstanceClassName = true) {
//		if($callMakeInstanceClasName) $entryClassName = tx_div::makeInstanceClassName($entryClassName);
//		for($this->rewind(); $this->valid(); $this->next())
//			$this->set($this->key(), new $entryClassName($this->controller, tx_div::toHashArray($this->current())));
		for ($this->rewind(); $this->valid(); $this->next()) {
			$this->set($this->key(), GeneralUtility::makeInstance($entryClassName, $this->controller, TxDiv::toHashArray($this->current())));
		}
	}


	/**
	 * Returns the key of the current element in array.
	 *
	 * @return    mixed        the key of the current element
	 */
	function key() {
		return $this->_iterator->key();
	}


	/**
	 * Set or exchange all array values
	 *
	 * On the one hand it works as an alias to $this->exchangeArray().
	 * On the other it is a little more flexible, as it takes all data members
	 * of the tx_div hash family as parameters.
	 *
	 * @param    mixed        $hashData ash array, SPL object or hash string ( i.e. "key1 : value1, key2 : valu2,
	 * ... ")
	 * @param    string        $splitCharacters possible split charaters in case the first parameter is a hash string
	 * @return    void
	 * @see        tx_div::toHashArray()
	 */
	function setArray($hashData, $splitCharacters = ',;:\s') {
		$this->exchangeArray(TxDiv::toHashArray($hashData, $splitCharacters));
	}


	/**
	 * Dump the internal data array
	 *
	 * If a key is given, only the value is selected.
	 *
	 * @param   mixed $key optional key
	 * @return    void
	 */
	function dump($key = NULL) {
		if ($key)
			$value = $this->get($key);
		else
			$value = $this->getHashArray();
		print '<pre>';
		print htmlspecialchars(print_r($value, 1));
		print '</pre>';
	}


	/**
	 * Get a value for a key
	 *
	 * It's just a convenient way to use the offsetGet() function from tx_lib_spl_arrayObject.
	 *
	 * @param    mixed        $key key
	 * @return    mixed        value
	 * @see        tx_lib_spl_arrayObject::offsetGet()
	 */
	function get($key) {
		return $this->offsetGet($key);
	}


	// -------------------------------------------------------------------------------------
	// Getters
	// -------------------------------------------------------------------------------------


	/**
	 * Returns the element at the given offset.
	 *
	 * @param    integer        $index the index of the element to be returned
	 * @return    mixed        the element at given index
	 */
	function offsetGet($index) {
		return $this->_iterator->offsetGet($index);
	}


	/**
	 * Alias for getArrayCopy
	 *
	 * @return    array        Copy of the internal array
	 */
	function getHashArray() {
		return $this->getArrayCopy();
	}


	/**
	 * Returns a copy of the array handled by this object.
	 *
	 * @return    array        a copy of the array
	 */
	function getArrayCopy() {
		return $this->_iterator->getArrayCopy();
	}


	/**
	 * Export the data as an object containing a list of objects
	 *
	 * This object has to contain a list of hash data.
	 * The hash data is created into the exported object as hash objects.
	 * The classes of the exported object and the entries are take as arguments.
	 *
	 * @param    string        $outputListClass Classname of exported object, defaults to tx_lib_object.
	 * @param    string        $outputEntryClass Classname of exported entries, defaults to tx_lib_object.
	 * @return    object  The exported object.
	 */
	function toObjectOfObjects($outputListClass = '\\Spin\\Lib\\Object', $outputEntryClass = '\\Spin\\Lib\\Object') {
		$this->checkController(__FILE__, __LINE__);
		$outputList = GeneralUtility::makeInstance($outputListClass);
		$outputList->controller = $this->controller;
//		$outputEntryClassName = tx_div::makeInstanceClassName($outputEntryClass);
//		for($this->rewind(); $this->valid(); $this->next())
//			$outputList->append(new $outputEntryClassName($this->controller, tx_div::toHashArray($this->current())));
		for ($this->rewind(); $this->valid(); $this->next()) {
			$outputList->append(GeneralUtility::makeInstance($outputEntryClass, $this->controller, TxDiv::toHashArray($this->current())));
		}

		return $outputList;
	}


	/**
	 * Find out if there is a content for this key
	 *
	 * Returns true if something has been set for the variable,
	 * even if it is 0 or the empty string.
	 *
	 * @param    mixed        $key key of internal data array
	 * @return    boolean        is something set?
	 */
	function has($key) {
		return ($this->get($key) != NULL);
	}


	/**
	 * Find out if this object has something in his data array
	 *
	 * @return    boolean        is it empty?
	 */
	function isEmpty() {
		return ($this->count() == 0);
	}


	/**
	 * Counts the elements in the array.
	 *
	 * @return    integer        number of elements
	 */
	function count() {
		return $this->_iterator->count();
	}


	/**
	 * Find out if this object has something in his data array
	 *
	 * @return    boolean        is something in it?
	 */
	function isNotEmpty() {
		return ($this->count() > 0);
	}


	// -------------------------------------------------------------------------------------
	// Session
	// -------------------------------------------------------------------------------------


	/**
	 * Return a selection of the object values as hash array.
	 *
	 * The parameter is of the list family defined in tx_div. (object, array, string)
	 * The return value is an of the hash type defind in tx_div.
	 *
	 * @param    mixed        $keys string, array or object of the tx_div list family
	 * @param    string        $splitCharacters a string of characters to split the keys string
	 * @return    array        selected values associative array
	 * @see        tx_div:toListArray();
	 */
	function selectHashArray($keys, $splitCharacters = ',;:\s') {
		$return = array();
		foreach (TxDiv::toListArray($keys, $splitCharacters) as $key) {
			$return[$key] = $this->get($key);
		}

		return (array)$return;
	}


	/**
	 * Stores this object data under the key "key" into the current session.
	 *
	 * @param    mixed        $key the key
	 * @return    void
	 */
	function storeToSession($key) {
		session_start();
		$_SESSION[$key] = GeneralUtility::makeInstance('\\Spin\\Lib\\Object', $this); // use a copy resp. a new object (for PHP4)
		$_SESSION[$key . '.']['className'] = $this->getClassName();
	}


	// -------------------------------------------------------------------------------------
	// GetSetters for the controller
	// -------------------------------------------------------------------------------------


	/**
	 * Retrieves data from the current session. The data is accessed by "key".
	 *
	 * @param    mixed        $key the key
	 * @return    void
	 */
	function loadFromSession($key) {
		session_start();
		if ($className = $_SESSION[$key . '.']['className']) {
			GeneralUtility::makeInstance($className);
			session_write_close();
			session_start();
			$this->overwriteArray($_SESSION[$key]);
		}
	}


	/**
	 * Set and get the controller object
	 *
	 * @param    \Spin\Lib\Controller $object controller type
	 * @return   \Spin\Lib\Controller controller type
	 */
	function controller(Controller $object = NULL) {
		$object = $this->controller = $object ? $object : $this->controller;
		if (!$object) die('Missing controller in ' . __CLASS__ . ' line ' . __LINE__);

		return $object;
	}


}
