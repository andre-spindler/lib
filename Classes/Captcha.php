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
 * A class to provide easy access to captcha generation
 *
 * Create a new captcha:
 * <code>
 *  $captcha = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\Spin\\Lib\\Captcha', $this);
 *  $captcha->createTest($this->getClassName());
 * </code>
 *
 * Check if captcha question has been ansered correctly:
 * <code>
 *  $captcha = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\Spin\\Lib\\Captcha', $this);
 *  if(!$captcha->ok($this->getClassName())) {
 *    // Ask another question and another question and ...
 *  } else { // Captcha test passed:
 *    // Do something now
 *  }
 * </code>
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */


class Captcha extends Object {

	/**
	 * Create a new question for the captcha.
	 *
	 * @param	integer		a unique key for this session to store the answer under
	 * @param	string		name of function to generate the captcha
	 * @return	void
	 */
	function createTest($id, $type = 'math1') {
		session_start();
		$functionName = '_' . $type . 'Test';
		list($question, $input, $answer) = $this->$functionName();
		$this->set('_captchaQuestion', $question);
		$this->set('_captchaInput', $input);
		$this->set('_captchaAnswer', $answer);
		$_SESSION['_captchaAnswer'][$id] = $answer;
	}

	/**
	 * Checks if the user given answer to a captcha is equal to the saved preset.
	 *
	 * @param	integer		a unique key for this session to get the answer from
	 * @return	boolean		true if the anwser is correct, false otherwise
	 */
	function ok($id) {
		session_start();
		$answer = (string) trim($_SESSION['_captchaAnswer'][$id]);
		$try    = (string) trim($this->controller->parameters->get('captcha'));
		return (strlen($try) && $try === $answer);
	}

	/**
	 * Calculates a new question for a captcha and saves the correct answer.
	 *
	 * This is the default captcha generation method.
	 *
	 * @return	array		array of captcha parameters
	 */
	function _math1Test() {
		$value1 = rand(0, 1000);
		$value2 = rand(0, 10);
		$signs = array('%%%minus%%%' => '-', '%%%plus%%%' => '+');
		$key = array_rand($signs);

		$question = $value1 . ' ' . $key . ' ' . $value2;
		$input = '<input name="' . $this->getDefaultDesignator() . '[captcha]" value=""%s />';
		eval('$answer = ' . $value1 . ' ' . $signs[$key] . ' ' . $value2 . ';');
		return array($question, $input, $answer);
	}

}