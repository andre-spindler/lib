<?php

namespace Spin\Lib;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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
 * Provide some typical information for all objects of this library
 *
 * @package    TYPO3
 * @subpackage div
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class SelfAwareness {


	/**
	 * cObj
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	var $cObjectSingleton = '';

	/**
	 * Designator
	 *
	 * @var string
	 */
	var $defaultDesignator = '';

	/**
	 * Destination
	 *
	 * @var string
	 */
	var $defaultDestination = '';

	/**
	 * Controller
	 *
	 * @var \Spin\Lib\Controller
	 */
	var $controller = NULL;


	// -------------------------------------------------------------------------------------
	// Setters
	// -------------------------------------------------------------------------------------


	/**
	 * Includes a file of the extension.
	 *
	 * Takes a filepath relative to the extensions main directory and includes it.
	 *
	 * @param    string $relativePath file path relative to the extensions main directory
	 * @return    void
	 */
	public function includeExtensionFile($relativePath) {
		include($this->getExtensionPath() . $relativePath);
	}


	/**
	 * Find the absolute path of this extension.
	 *
	 * @return    string        path to the extension
	 * @see        t3lib_extMgm::extPath()
	 */
	function getExtensionPath() {
		return ExtensionManagementUtility::extPath($this->getExtensionKey());
	}


	/**
	 * Get the extension key.
	 *
	 * Automatically detects the extension key from the classname.
	 *
	 * @return    string        extension key
	 */
	function getExtensionKey() {
		if (preg_match('/^tx_([^_]+)/', get_class($this), $matches) ||
				preg_match('/^Tx([^_]+)/', get_class($this), $matches) ||
				preg_match('/^user_([^_]+)/', get_class($this), $matches)
		) {
			$candidate = strtolower($matches[1]);
			if ($candidate != 'lib') {
				$keys = GeneralUtility::trimExplode(',', strtolower($GLOBALS['TYPO3_CONF_VARS']['EXT']['extList']));
				foreach ($keys as $key) {
					if ($candidate == str_replace('_', '', $key)) {
						return $key;
					}
				}
			}
		}
		$matches = explode('\\', __NAMESPACE__);
		$candidate = strtolower($matches[1]);
		if (ExtensionManagementUtility::isLoaded($candidate)) {
			return $candidate;
		}
		if ('error') {
			$message = 'No extension key could be found.' . chr(10);
			$this->_die($message, __FILE__, __LINE__);
		}

		return '';
	}


	// -------------------------------------------------------------------------------------
	// Getters
	// -------------------------------------------------------------------------------------


	/**
	 * Exits the current script with die() and prints a message and a file/line pair.
	 *
	 * @param    string        $text message to display
	 * @param    string        $file filename the script died
	 * @param    integer        $line linenumber the script died
	 * @return    void
	 * @access    protected
	 */
	function _die($text, $file, $line) {
		print '<h1>You died:</h1>';
		print '<pre><strong>' . chr(10) . $text . chr(10) . '</strong></pre>';
		print '<p>File: ' . $file . '</p>';
		print '<p>Line: ' . $line . '</p>';
		die();
	}


	/**
	 * Development helper function.
	 *
	 * Displays class methods, variables and all declared classes.
	 * Then exits the script.
	 *
	 * @return    void
	 */
	public function api() {
		print '<h1>Class: ' . get_class($this) . '</h1>';
		print '<h2>Methods:</h2>';
		$methods = get_class_methods($this);
		if ($methods) {
			sort($methods);
			print '<ul>' . chr(10);
			foreach ($methods as $name) {
				print '<li>' . $name . '</li>' . chr(10);
			}
			print '</ul>' . chr(10);
		}
		print '<h2>Variables:</h2>';
		$variables = get_class_vars(get_class($this));
		if ($variables) {
			ksort($variables);
			print '<dl>' . chr(10);
			foreach ($variables as $name => $value) {
				print '<dt><b>' . $name . ':</b></dt>' . chr(10);
				print '<dd>' . $value . '</dd>' . chr(10);
			}
			print '</dl>' . chr(10);
		}
		print '<h2>Declared classes:</h2>';
		$declaredClasses = get_declared_classes();
		if ($declaredClasses) {
			sort($declaredClasses);
			print '<ul>' . chr(10);
			foreach ($declaredClasses as $name) {
				print '<li>' . $name . '</li>' . chr(10);
			}
			print '</ul>' . chr(10);
		}
		exit();
	}


	/**
	 * Singleton to access the features of cObject.
	 *
	 * This cObject should only be used to access cObject functionality, not to store
	 * any data into it, because it is a singleton and may by used from several places.
	 * Also the scope of the singleton may be altered in future.
	 *
	 * @return    \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public function findCObject() {
		if (!$this->cObjectSingleton) {
			$this->cObjectSingleton = GeneralUtility::makeInstance('\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
		}

		return $this->cObjectSingleton;
	}


	/**
	 * Return the classname.
	 *
	 * In PHP4 the classname is returned in lowercase.
	 * So this is only usefull for caseinsensitive tasks.
	 *
	 * @return    string        classname
	 */
	public function getClassName() {
		return get_class($this);
	}


	/**
	 * Get the extension prefix.
	 *
	 * Returns the extension prefix based on $this->extensionKey.
	 * That is the extension key with underscores stripped and prefixed with tx_.
	 *
	 * The extension prefix is used by table names and for lot of other matters.
	 * See the TYPO3 coding guidelines for all information.
	 *
	 * @return    string        extension key
	 * @see        getExtensionKey()
	 */
	function getExtensionPrefix() {
		return 'Tx' . str_replace('_', '', $this->getExtensionKey());
	}


	/**
	 * Returns the id of the current frontside page.
	 *
	 * @return    integer        frontside page UID
	 */
	function getPageId() {
		return $GLOBALS['TSFE']->id;
	}


	/**
	 * Returns the result status of the object
	 *
	 * @return string
	 * @status alphpa
	 */
	function getResultStatus() {
		return 1;
	}


	/**
	 * Return the default designator.
	 *
	 * Alias for getDefaultDesignator();
	 *
	 * @return    string        default designator
	 * @see        getDefaultDesignator()
	 */
	function getDesignator() {
		return $this->getDefaultDesignator();
	}


	/**
	 * Return the default designator.
	 *
	 * A designator is the name of the parameter array of forms and url and may by used for
	 * other identification purpuses. In tslib_pibase it is called prefixId.
	 *
	 * A default designator can be set as class variable.
	 * It defaults to the extension key of the controller.
	 *
	 * @return    string        default designator
	 */
	public function getDefaultDesignator() {
		if ($this->defaultDesignator) {
			return $this->defaultDesignator; // explicit given designator
		} elseif (is_object($this->controller)) {
			return $this->controller->getDefaultDesignator(); // the controllers designator
		} else {
			return $this->getExtensionKey(); // the own extension key (it's the controller)
		}
	}


	/**
	 * Set the default designator.
	 *
	 * Usefull for classes of the library tx_lib that are not inherited but directly instantiated.
	 *
	 * A default designator is rarely set explicitly. Typically you will use the fallback of the designator,
	 * the extension key by calling getDefaultDesignator() or getDesignator().
	 *
	 * @param    string $string designator
	 * @return    void
	 * @see        getDesignator()
	 * @see        getDefaultDesignator()
	 */
	public function setDefaultDesignator($string) {
		$this->defaultDesignator = $string;
	}


	// -------------------------------------------------------------------------------------
	// Aliases
	// -------------------------------------------------------------------------------------


	/**
	 * Return the default destination
	 *
	 * Alias for getDefaultDestination();
	 *
	 * @return    string        default destination
	 * @see        getDefaultDestination()
	 */
	function getDestination() {
		return $this->getDefaultDestination();
	}


	/**
	 * Return the default destination of links.
	 *
	 * A default designation can be set to be used by links.
	 * It defaults to the page id of the controller.
	 *
	 * @return    string        default designator
	 */
	function getDefaultDestination() {
		if ($this->defaultDestination) {
			return $this->defaultDestination; // explicitly given destination
		} elseif (is_object($this->controller)) {
			return $this->controller->getDefaultDestination(); // the controllers destination
		} else {
			return $GLOBALS['TSFE']->id; // the page id (it's the controller)
		}
	}

	// -------------------------------------------------------------------------------------
	// Helper
	// -------------------------------------------------------------------------------------


	/**
	 * Set the destination.
	 *
	 * The default destionation of
	 *
	 * @param    string        $string destination
	 * @return    void
	 * @see        getDestination()
	 * @see        getDefaultDestination()
	 */
	public function setDefaultDestination($string) {
		$this->defaultDestination = $string;
	}


}
