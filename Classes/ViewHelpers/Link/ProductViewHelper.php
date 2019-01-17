<?php

namespace Extcode\CartProducts\ViewHelpers\Link;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProductViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('product', \Extcode\CartProducts\Domain\Model\Product\Product::class, 'product', true);
        $this->registerArgument('settings', 'array', 'settings array', true);
    }

    /**
     * @param string $action Target action
     * @param array $arguments Arguments
     * @param string $controller Target controller. If NULL current controllerName is used
     * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
     * @param string $pluginName Target plugin. If empty, the current plugin name is used
     * @param int $pageUid target page. See TypoLink destination
     * @param int $pageType type of the target page. See typolink.parameter
     * @param bool $noCache set this to disable caching for the target page. You should not need this.
     * @param bool $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
     * @param string $section the anchor to be added to the URI
     * @param string $format The requested format, e.g. ".html
     * @param bool $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
     * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
     * @param bool $absolute If set, the URI of the rendered link is absolute
     * @param bool $addQueryString If set, the current query parameters will be kept in the URI
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = true
     * @param string $addQueryStringMethod Set which parameters will be kept. Only active if $addQueryString = true
     * @return string Rendered link
     */
    public function render(
        $action = null,
        array $arguments = [],
        $controller = null,
        $extensionName = null,
        $pluginName = null,
        $pageUid = null,
        $pageType = 0,
        $noCache = false,
        $noCacheHash = false,
        $section = '',
        $format = '',
        $linkAccessRestrictedPages = false,
        array $additionalParams = [],
        $absolute = false,
        $addQueryString = false,
        array $argumentsToBeExcludedFromQueryString = [],
        $addQueryStringMethod = null
    ) {
        $product = $this->arguments['product'];

        $page = $this->getProductPage($product);
        if ($page) {
            $this->arguments['pageUid'] = $page['uid'];
        } else {
            if ($product->getCategory() && $product->getCategory()->getCartProductShowPid()) {
                $this->arguments['pageUid'] = $product->getCategory()->getCartProductShowPid();
            } elseif ($this->arguments['settings']['showPageUids']) {
                $this->arguments['pageUid'] = $this->arguments['settings']['showPageUids'];
            }

            $this->arguments['action'] = 'show';
            $this->arguments['arguments'] = [
                'product' => $product
            ];
        }
        return parent::render();
    }

    /**
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $product
     * @return array|bool
     */
    protected function getProductPage(\Extcode\CartProducts\Domain\Model\Product\Product $product)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        return $queryBuilder->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('cart_products_product', $product->getUid())
            )
            ->orderBy('sorting')
            ->setMaxResults(1)
            ->execute()
            ->fetch();
    }
}
