<?php

namespace Extcode\CartProducts\Controller;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Service\SessionHandler;
use Extcode\Cart\Utility\CartUtility;
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Repository\CategoryRepository;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Mvc\Web\RequestBuilder;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Service\ExtensionService;

class ProductController extends ActionController
{
    protected ExtensionService $extensionService;

    protected SessionHandler $sessionHandler;

    protected Cart $cart;

    protected CartUtility $cartUtility;

    protected ProductRepository $productRepository;

    protected CategoryRepository $categoryRepository;

    protected array $searchArguments = [];

    protected array $cartConfiguration = [];

    public function __construct(
        ExtensionService $extensionService,
        SessionHandler $sessionHandler,
        CartUtility $cartUtility,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->extensionService = $extensionService;
        $this->sessionHandler = $sessionHandler;
        $this->cartUtility = $cartUtility;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    protected function initializeAction()
    {
        $this->cartConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK,
            'Cart'
        );

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            static $cacheTagsSet = false;

            $typoScriptFrontendController = $GLOBALS['TSFE'];
            if (!$cacheTagsSet) {
                $typoScriptFrontendController->addCacheTags(['tx_cartproducts']);
                $cacheTagsSet = true;
            }
        }

        $this->settings['addToCartByAjax'] = isset($this->settings['addToCartByAjax']) ? (int)$this->settings['addToCartByAjax'] : 0;
    }

    /**
     * Create the demand object which define which records will get shown
     */
    protected function createDemandObjectFromSettings(array $settings): ProductDemand
    {
        /** @var ProductDemand $demand */
        $demand = GeneralUtility::makeInstance(
            ProductDemand::class
        );

        if (!empty($this->searchArguments['sku'])) {
            $demand->setSku($this->searchArguments['sku']);
        }
        if (!empty($this->searchArguments['title'])) {
            $demand->setTitle($this->searchArguments['title']);
        }
        if ($settings['orderBy']) {
            if (
                !isset($settings['orderDirection']) &&
                $settings['orderDirection'] !== 'DESC'
            ) {
                $settings['orderDirection'] = 'ASC';
            }
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    protected function addCategoriesToDemandObjectFromSettings(ProductDemand $demand): void
    {
        if ($this->settings['categoriesList']) {
            $selectedCategories = GeneralUtility::intExplode(
                ',',
                $this->settings['categoriesList'],
                true
            );

            $categories = [];

            if ($this->settings['listSubcategories']) {
                foreach ($selectedCategories as $selectedCategory) {
                    $category = $this->categoryRepository->findByUid($selectedCategory);
                    $categories = array_merge(
                        $categories,
                        $this->categoryRepository->findSubcategoriesRecursiveAsArray($category)
                    );
                }
            } else {
                $categories = $selectedCategories;
            }

            $demand->setCategories($categories);
        }
    }

    public function listAction(int $currentPage = 1): ResponseInterface
    {
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $itemsPerPage = $this->settings['itemsPerPage'] ?? 20;

        $products = $this->productRepository->findDemanded($demand);
        $arrayPaginator = new QueryResultPaginator(
            $products,
            $currentPage,
            $itemsPerPage
        );
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'products' => $products,
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]
        );

        $this->view->assign('searchArguments', $this->searchArguments);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($products);
        return $this->htmlResponse();
    }

    /**
     * @IgnoreValidation("product")
     */
    public function showAction(Product $product = null): ResponseInterface
    {
        if (!$product) {
            $product = $this->getProduct();
        }
        if (!$product) {
            return new ForwardResponse('list');
        }

        $this->view->assign('user', $GLOBALS['TSFE']->fe_user->user);
        $this->view->assign('product', $product);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags([$product]);
        return $this->htmlResponse();
    }

    public function showFormAction(Product $product = null): ResponseInterface
    {
        if (!$product) {
            $product = $this->getProduct();
        }

        $this->view->assign('product', $product);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();
        return $this->htmlResponse();
    }

    public function teaserAction(): ResponseInterface
    {
        $products = $this->productRepository->findByUids($this->settings['productUids']);

        $this->view->assign('products', $products);
        $this->view->assign('cartSettings', $this->cartConfiguration['settings']);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($products);
        return $this->htmlResponse();
    }

    public function flexformAction(): ResponseInterface
    {
        $contentObj = $this->configurationManager->getContentObject();
        $contentId = $contentObj->data['uid'];

        $this->view->assign('contentId', $contentId);
        return $this->htmlResponse();
    }

    protected function getProduct(): ?Product
    {
        $productUid = $this->getProductUid();

        if ($productUid > 0) {
            $product = $this->productRepository->findByUid($productUid);

            if ($product instanceof Product) {
                return $product;
            }
        }

        return null;
    }

    /**
     * @return int|mixed
     * @throws InvalidConfigurationTypeException
     */
    public function getProductUid(): mixed
    {
        if ((int)$GLOBALS['TSFE']->page['doktype'] === 183) {
            return (int)$GLOBALS['TSFE']->page['cart_products_product'];
        }

        if ($this->request->getPluginName() !== 'ProductPartial') {
            return 0;
        }

        $configurationManager = GeneralUtility::makeInstance(
            ConfigurationManager::class
        );
        $configuration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK);

        $typoscriptService = GeneralUtility::makeInstance(
            TypoScriptService::class
        );
        $configuration = $typoscriptService->convertPlainArrayToTypoScriptArray($configuration);
        $productUid = (int)$configurationManager->getContentObject()->cObjGetSingle($configuration['product'], $configuration['product.']);

        if ($productUid === 0) {
            $configurationManager->setConfiguration([
                'vendorName' => 'Extcode',
                'extensionName' => 'CartProducts',
                'pluginName' => 'Products',
            ]);
            $requestBuilder = GeneralUtility::makeInstance(
                RequestBuilder::class,
                $this->configurationManager,
                $this->extensionService
            );

            /**
             * @var Request $cartProductRequest
             */
            $cartProductRequest = $requestBuilder->build($this->request);

            if ($cartProductRequest->hasArgument('product')) {
                $productUid = (int)$cartProductRequest->getArgument('product');
            }
        }

        return $productUid;
    }

    /**
     * assigns currency translation array to view
     */
    protected function assignCurrencyTranslationData()
    {
        $this->restoreSession();

        $currencyTranslationData = [
            'currencyCode' => $this->cart->getCurrencyCode(),
            'currencySign' => $this->cart->getCurrencySign(),
            'currencyTranslation' => $this->cart->getCurrencyTranslation(),
        ];

        $this->view->assign('currencyTranslationData', $currencyTranslationData);
    }

    protected function addCacheTags(iterable $products): void
    {
        $cacheTags = [];

        foreach ($products as $product) {
            // cache tag for each product record
            $cacheTags[] = 'tx_cartproducts_product_' . $product->getUid();
        }
        if (count($cacheTags) > 0) {
            $GLOBALS['TSFE']->addCacheTags($cacheTags);
        }
    }

    protected function restoreSession(): void
    {
        $cart = $this->sessionHandler->restoreCart($this->cartConfiguration['settings']['cart']['pid']);

        if ($cart instanceof Cart) {
            $this->cart = $cart;
            return;
        }

        $this->cart = $this->cartUtility->getNewCart($this->cartConfiguration);
        $this->sessionHandler->writeCart($this->cartConfiguration['settings']['cart']['pid'], $this->cart);
    }
}
