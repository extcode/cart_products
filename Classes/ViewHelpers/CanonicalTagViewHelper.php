<?php

namespace Extcode\CartProducts\ViewHelpers;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class CanonicalTagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'link';

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'product',
            Product::class,
            'product',
            false,
            0
        );
    }

    /**
     * Override the canonical tag
     */
    public function render(): void
    {
        $product = $this->arguments['product'];

        // get topic category
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

        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
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
     * @return PageRenderer
     */
    protected function getPageRenderer()
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend() && is_callable([$this->getTypoScriptFrontendController(), 'getPageRenderer'])) {
            return $this->getTypoScriptFrontendController()->getPageRenderer();
        }

        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
