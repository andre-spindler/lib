<?php

namespace Spin\Lib\ResultBrowser;

use \Spin\Lib;
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
 * Controller class of the resultbrowser
 *
 * Create a resultbrowser:
 * <code>
 *  $resultbrowser = tx_div::makeInstance('tx_lib_resultBrowser_controller');
 *  $resultbrowser->main(NULL, $configuration, $parameters, $context);
 * </code>
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */


class Controller extends Lib\Controller {

	function defaultAction() {
        /** @var \Spin\Lib\ResultBrowser\Model $model */
		$model = GeneralUtility::makeInstance('\\Spin\\Lib\\ResultBrowser\\Model', $this, $this->controller);
        /** @var \Spin\Lib\ResultBrowser\View $view */
		$view = GeneralUtility::makeInstance('\\Spin\\Lib\ResultBrowser\\View', $model, $this);
		$view->setPathToTemplateDirectory('EXT:lib/Resources/Private/Templates/ResultBrowser/');
		return $view->render('Template.php');
	}

}
