<?php

namespace Extcode\CartProducts\ViewHelpers;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class CanonicalTagViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'link';

    public function __construct(
        private readonly UriBuilder $uriBuilder,
        private readonly PageRenderer $pageRenderer
    ) {
        parent::__construct();
    }

    public function initializeArguments(): void
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

    public function render(): string
    {
        $product = $this->arguments['product'];

        // get topic category
        $category = $product->getCategory();

        if (!$category) {
            return '';
        }

        $pageUid = $category->getCartProductShowPid();

        if (!$pageUid) {
            return '';
        }

        $arguments = [
            ['tx_cartproducts_product'
                => [
                    'controller' => 'Product',
                    'product' => $product->getUid(),
                ],
            ],
        ];

        $uriBuilder = $this->uriBuilder;
        $uriBuilder->reset();
        $canonicalUrl = $uriBuilder
            ->setTargetPageUid($pageUid)
            ->setCreateAbsoluteUri(true)
            ->setArguments($arguments)
            ->build();

        $this->tag->addAttribute('rel', 'canonical');
        $this->tag->addAttribute('href', $canonicalUrl);
        $this->pageRenderer->addHeaderData($this->tag->render());

        return '';
    }
}
