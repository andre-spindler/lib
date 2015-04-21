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
 * A <form> builder class controlled by a TypoScript config array.
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */


class FormBuilder extends Object {

    /**
     * @var \Spin\Lib\FormBase
     */
    var $form;

    /**
     * @var string
     */
    var $content = '';


	/**
	 * Builds the <form> from a TypoScript configuration.
	 *
	 * The configuration can be given either as string or array.
	 * If it is given as string, its parsed before building process into an array.
	 *
	 * @param	string|array	TypoScript configuration as string or array
	 * @return	void
	 */
	function build($setup) {
		if(is_string($setup))
			$setup = $this->_parseTs($setup);
		$this->form = GeneralUtility::makeInstance('\\Spin\\Lib\\FormBase'); //TODO
		$this->form->controller($this->controller);
		$this->form->requireListControl('<dl>', '</dl>');
		$this->form->setRowPattern('%1$s%4$s<dt>%2$s</dt>%4$s<dd>%3$s</dd>%4$s');
		$content = $this->form->begin($setup['key']);
		ksort($setup);
		foreach($setup as $key => $row) {
			if(is_numeric($key))
				$content .= $this->_buildRow($row);
		}
		$content .= $this->form->end();
		$this->content = $content;
	}


	/**
	 * Renders (returns) the HTML code of the build <form>.
	 *
	 * @return	string		HTML code of form
	 */
	function render() {
		return $this->content;
	}


	/**
	 * Renders a single <form> row depending on the given TypoScript config array.
	 *
	 * @param	array		TypoScript config array for a single row
	 * @return	string		HTML code of singe form row
	 * @access	protected
	 */
	function _buildRow($row) {
        $out = '';
		switch($element = $row['element']) {
			case 'checkboxRow':
				$out = $this->form->checkboxRow($row['key'], $row['label'], $row['attributes.'], $row['legend']);
				break;
			case 'fieldsetBegin':
				$out = $this->form->fieldsetBegin($row['key'], $row['attributes.'], $row['legend']);
				break;
			case 'fieldsetEnd':
				$out = $this->form->fieldsetEnd();
				break;
			case 'multicheckboxesRow':
				$out = $this->form->multicheckboxesRow($row['key'], $row['label'], $row['attributes.'], $row['options.']);
				break;
			case 'multiselectRow':
				$out = $this->form->multiselectRow($row['key'], $row['label'], $row['attributes.'], $row['options.']);
				break;
			case 'selectRow':
				$out = $this->form->selectRow($row['key'], $row['label'], $row['attributes.'], $row['options.']);
				break;
			default:
				if(method_exists($this->form, $element)) {
					if(substr($element, -3) == 'Row')
						$out = $this->form->$element($row['key'], $row['label'], $row['attributes.']);
					else
						$out = $this->form->$element($row['key'], $row['attributes.']);
				}
		}
		return $out;
	}


	/**
	 * Helper function to parse a TypoScript string into an array.
	 *
	 * @param	string		the TypoScript config as string
	 * @return	array		the TypoScript config as array
	 * @access	protected
	 */
	function _parseTs($typoScript) {
        /** @var \TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser $TSparserObject */
		$TSparserObject = GeneralUtility::makeInstance('\\TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
		$TSparserObject->parse($typoScript);
		return $TSparserObject->setup;
	}

}
