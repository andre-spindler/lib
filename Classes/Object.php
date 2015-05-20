<?php

namespace Spin\Lib;

use Spin\Lib\Spl;

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
 * This is the "pluripotent stem cell" of lib/div.
 *
 * <b>MOST CENTRAL OBJECT</b>
 *
 * This object is the common parent of almoust all objects used in lib/div development. It provides
 * functionality and an API that all lib/div objects have in common. By knowing this object you know
 * 90% of all objects.
 *
 * This class implements the powerfull PHP5 interfaces <b>ArrayAccess</b> and <b>Iterator</b> and
 * also backports them for PHP4. This is done by implementing the central SPL classes <b>ArrayObject</b>
 * and <b>ArrayIterator</b> in form of plain PHP code.
 *
 * <a href="http://de2.php.net/manual/en/ref.spl.php">See Standard PHP Library</a>
 *
 * <b>ArrayAccess</b>
 *
 * Access the values of an object by keys like an array.
 *
 * PHP5:
 *   $value = $this->parameters['exampleKey']
 * PHP4 and PHP5:
 *   $value = $this->parameters->get('exampleKey');
 *
 * <b>Iterator</b>
 *
 * Iterate over the values of an object just like an array.
 *
 * PHP5:
 *   foreach($this->parameters as $key => $value) { ... }
 * PHP4 and PHP5:
 *   for($this->parameters->rewind(), $this->parameters->valid(), $this->parameters->next()) {
 *      $key = $this->parameters->key();
 *      $value = $this->parameters->current();
 *   }
 *
 * <b>The request cycle as a chain of SPL objects</b>
 *
 * A central feature of SPL objects is the possiblity to feed one SPL object into the constructor of the next.
 * By this list of values can be processed by a chain of SPL objects alwasys using the same simple API.
 * It is suggested to implement the different stations of the request cycle from request to response in form
 * of SPL objects.
 *
 * The class provides a lot of addiotional functions to make setting and getting still more comfortables.
 * Functions to store the data into the session are also provided.
 *
 *
 * Depends on: tx_lib_objectBase
 * Used by: All object within this framework by direct or indirect inheritance.
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class Object extends ObjectBase implements \ArrayAccess, \SeekableIterator {


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	public function __construct($parameter1 = NULL, $parameter2 = NULL) {
		$this->Object($parameter1, $parameter2);
	}


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	public function Object($parameter1 = NULL, $parameter2 = NULL) {
		parent::ObjectBase($parameter1, $parameter2);
	}

}
