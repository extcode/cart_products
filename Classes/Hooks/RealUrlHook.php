<?php

namespace Extcode\CartProducts\Hooks;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use DmitryDulepov\Realurl\Configuration\ConfigurationReader;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RealUrlHook
{
    /**
     * @param array &$parameters
     * @param ConfigurationReader $configurationReader
     */
    public function postProcessConfiguration(&$parameters, ConfigurationReader $configurationReader)
    {
        if (!isset($parameters['configuration']['fixedPostVars']['cartproductsShowProduct'])
        ) {
            return;
        }

        if ($configurationReader->getMode() === ConfigurationReader::MODE_DECODE) {
            $targetPageId = $this->getTypoScriptFrontendController()->id;
            $pageRecord = $this->getTypoScriptFrontendController()->page;
        } else {
            $targetPageId = $parameters['urlParameters']['id'];
            $pageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
            $pageRecord = $pageRepository->getPage($parameters['urlParameters']['id']);
        }

        if ($pageRecord) {
            switch ((int)$pageRecord['doktype']) {
                case 182:
                    $parameters['configuration']['fixedPostVars'][$targetPageId] = 'cartproductsShowProduct';
                    break;
            }
        }

        return;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
