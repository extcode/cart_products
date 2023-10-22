<?php

namespace Extcode\CartProducts\Controller;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Core\Http\ApplicationType;
use Extcode\Cart\Service\SessionHandler;
use Extcode\Cart\Utility\CartUtility;
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Repository\CategoryRepository;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\RequestBuilder;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

class ProductController extends ActionController
{
    /**
     * @var SessionHandler
     */
    protected $sessionHandler;

    /**
     * @var CartUtility
     */
    protected $cartUtility;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var array
     */
    protected $searchArguments;

    /**
     * @var array
     */
    protected $cartSettings = [];

    public function injectSessionHandler(SessionHandler $sessionHandler): void
    {
        $this->sessionHandler = $sessionHandler;
    }

    public function injectCartUtility(CartUtility $cartUtility): void
    {
        $this->cartUtility = $cartUtility;
    }

    public function injectProductRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    protected function initializeAction()
    {
        $this->cartSettings = $this->configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
            'Cart'
        );

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            static $cacheTagsSet = false;

            /** @var $typoScriptFrontendController \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController */
            $typoScriptFrontendController = $GLOBALS['TSFE'];
            if (!$cacheTagsSet) {
                $typoScriptFrontendController->addCacheTags(['tx_cartproducts']);
                $cacheTagsSet = true;
            }
        }
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

        if (is_array($this->searchArguments) && isset($this->searchArguments['sku'])) {
            $demand->setSku($this->searchArguments['sku']);
        }

        if (is_array($this->searchArguments) && isset($this->searchArguments['title'])) {
            $demand->setTitle($this->searchArguments['title']);
        }

        if (is_array($this->searchArguments) && isset($this->searchArguments['orderBy'])) {
            $demand->setTitle($this->searchArguments['orderBy']);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    protected function addCategoriesToDemandObjectFromSettings(ProductDemand $demand): void
    {
        if ($this->settings['categoriesList'] ?? 0) {
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
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($products);
        return $this->htmlResponse();
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("product")
     */
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
        $this->view->assign('cartSettings', $this->cartSettings);

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
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();
        return $this->htmlResponse();
    }

    public function teaserAction(): ResponseInterface
    {
        $products = $this->productRepository->findByUids($this->settings['productUids']);

        $this->view->assign('products', $products);
        $this->view->assign('cartSettings', $this->cartSettings);

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
        $productUid = 0;

        if ((int)$GLOBALS['TSFE']->page['doktype'] === 183) {
            $productUid = (int)$GLOBALS['TSFE']->page['cart_products_product'];
        } else {
            if ($this->request->getPluginName() === 'ProductPartial') {
                if ($productUid === 0) {
                    $configurationManager = GeneralUtility::makeInstance(
                        ConfigurationManager::class
                    );
                    $configuration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK);

                    $typoscriptService = GeneralUtility::makeInstance(
                        TypoScriptService::class
                    );
                    $configuration = $typoscriptService->convertPlainArrayToTypoScriptArray($configuration);
                    $productUid = (int)$configurationManager->getContentObject()->cObjGetSingle($configuration['product'], $configuration['product.']);
                }
                if ($productUid === 0) {
                    $requestBuilder = GeneralUtility::makeInstance(
                        RequestBuilder::class
                    );
                    $configurationManager = GeneralUtility::makeInstance(
                        ConfigurationManager::class
                    );
                    $configurationManager->setConfiguration([
                        'vendorName' => 'Extcode',
                        'extensionName' => 'CartProducts',
                        'pluginName' => 'Products',
                    ]);
                    $requestBuilder->injectConfigurationManager($configurationManager);

                    /**
                     * @var Request $cartProductRequest
                     */
                    $cartProductRequest = $requestBuilder->build($this->request);

                    if ($cartProductRequest->hasArgument('product')) {
                        $productUid = (int)$cartProductRequest->getArgument('product');
                    }
                }
            }
        }

        $product = null; // Initializing the variable

        if ($productUid > 0) {
            $productRepository = GeneralUtility::makeInstance(
                ProductRepository::class
            );

            $product =  $productRepository->findByUid($productUid);
        }

        return $product;
    }

    /**
     * assigns currency translation array to view
     */
    protected function assignCurrencyTranslationData()
    {
        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()) {
            $currencyTranslationData = [];

            $cart = $this->sessionHandler->restore($this->settings['cart']['pid'] ?? 0);

            if ($cart) {
                $currencyTranslationData['currencyCode'] = $cart->getCurrencyCode();
                $currencyTranslationData['currencySign'] = $cart->getCurrencySign();
                $currencyTranslationData['currencyTranslation'] = $cart->getCurrencyTranslation();
            }

            $this->view->assign('currencyTranslationData', $currencyTranslationData);
        }
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
}
