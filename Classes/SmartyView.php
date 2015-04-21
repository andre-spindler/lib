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
 * A viewer class that is based on the extension 'rtp_smarty'.
 *
 * For initialisation call function init()
 *
 * To assign any variables for the template they are all stored in one masterArray.
 * If you want add a variable for the template add the variable to the masterArray
 * calling the function assignValue(pointer to the array, name of variable, value of variable, type of variable)
 *
 * Default extension of templates is 'tmpl', you can change it by function setTemplateExtension(), for example
 * tx_lib_smartyView::setTemplateExtension('html');
 *
 * To render the template just call the function render(templatename)
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */

class SmartyView extends ViewBase {

    /**
     * @var bool
     */
	var $available = false;

    var $smarty;


    /**
	 * Set the path of the template directory.
	 *
	 * You can make use the syntax  EXT:myextension/somepath.
	 * It will be evaluated to the absolute path by t3lib_div::getFileAbsFileName()
	 *
	 * @param	string		path to the directory containing the php templates
	 * @return	void
 	 */
	function setTemplatePath($pathToTemplates){
		$path = GeneralUtility::getFileAbsFileName($pathToTemplates);
		$this->pathToTemplates = $path;
	}


	/**
	 * Generates a link and returns the HTML-<a> tag.
	 *
	 * @param	string		URL of the link
	 * @param	string		Label for the link
	 * @return	string		Generated URL
	 */
	function printAsUrl($url, $label) {
        /** @var \Spin\Lib\Link $link */
		$link = GeneralUtility::makeInstance('\\Spin\\Lib\\Link');
		$link->destination($url);
		if($label) {
			$link->label($label, 1);
		}
		return $link->makeTag();
	}


	/**
	 * Render the PHP template, translate and return the output as string.
	 *
	 * @param	string		name of template file without the ".tpl" suffix
	 * @return	string		typically an (x)html string
	 */
    function render($view){
        if(ExtensionManagementUtility::isLoaded('rtp_smarty')) {
            require_once(ExtensionManagementUtility::extPath('rtp_smarty') . 'class.tx_rtpsmarty.php');
	        $this->smarty = tx_rtpsmarty::newSmartyTemplate();
        } else {
        	return 'smarty is not available';
        }

        $this->smarty->assign($this -> getArrayCopy());
        $this->smarty->assign_by_ref('view', $this);

        return $this->smarty->display($this->pathToTemplates . '/' . $view);
	}

}
