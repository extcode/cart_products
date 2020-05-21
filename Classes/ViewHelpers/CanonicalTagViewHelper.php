<?php

namespace Extcode\CartProducts\ViewHelpers;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * adds the canonical tag to header data
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class CanonicalTagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'link';

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('product', '\Extcode\CartProducts\Domain\Model\Product\Product', 'product', false, 0);
    }

    /**
     * Override the canonical tag
     */
    public function render()
    {
        $product = $this->arguments['product'];

        /* get topic category */
        $category = $product->getCategory();

        if (!$category) {
            return;
        }

        $pageUid = $category->getCartProductShowPid();

        if (!$pageUid) {
            return;
        }

        $arguments = [
            ['tx_cartproducts_product' =>
                [
                    'controller' => 'Product',
                    'product' => $product->getUid()
                ]
            ]
        ];

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $canonicalUrl = $uriBuilder->reset()
            ->setTargetPageUid($pageUid)
            ->setCreateAbsoluteUri(true)
            ->setArguments($arguments)
            ->build();

        $this->tag->addAttribute('rel', 'canonical');
        $this->tag->addAttribute('href', $canonicalUrl);
        $this->getPageRenderer()->addHeaderData($this->tag->render());
    }

    /**
     * @return \TYPO3\CMS\Core\Page\PageRenderer
     */
    protected function getPageRenderer()
    {
        if ('FE' === TYPO3_MODE && is_callable([$this->getTypoScriptFrontendController(), 'getPageRenderer'])) {
            return $this->getTypoScriptFrontendController()->getPageRenderer();
        } else {
            return GeneralUtility::makeInstance('TYPO3\CMS\Core\Page\PageRenderer');
        }
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
