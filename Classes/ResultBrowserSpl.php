<?php

namespace Spin\Lib;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ResultBrowserSpl extends Object {

	function buildAs($browserKey = 'browserKey', $totalResultCountKey = 'totalResultCountKey') {
        /** @var \Spin\Lib\ResultBrowser\Controller $resultbrowser */
		$resultbrowser = GeneralUtility::makeInstance('\\Spin\\Lib\\ResultBrowser\\Controller');
		$resultbrowser->setDefaultDesignator($this->getDefaultDesignator());
		$this->controller->configurations->set('totalResultCount', $this->controller->get($totalResultCountKey));
		$this->controller->set($browserKey, $resultbrowser->main(NULL, $this->controller->configurations));
	}

}
