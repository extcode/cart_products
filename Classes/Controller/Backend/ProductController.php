<?php

namespace Extcode\CartProducts\Controller\Backend;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;

class ProductController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Cart Utility
     *
     * @var \Extcode\Cart\Utility\CartUtility
     */
    protected $cartUtility;

    /**
     * productRepository
     *
     * @var \Extcode\CartProducts\Domain\Repository\Product\ProductRepository
     */
    protected $productRepository;

    /**
     * categoryRepository
     *
     * @var \Extcode\CartProducts\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Search Arguments
     *
     * @var array
     */
    protected $searchArguments;

    /**
     * Plugin Settings
     *
     * @var array
     */
    protected $pluginSettings;

    /**
     * @param \Extcode\Cart\Utility\CartUtility $cartUtility
     */
    public function injectCartUtility(
        \Extcode\Cart\Utility\CartUtility $cartUtility
    ) {
        $this->cartUtility = $cartUtility;
    }

    /**
     * @param \Extcode\CartProducts\Domain\Repository\Product\ProductRepository $productRepository
     */
    public function injectProductRepository(
        \Extcode\CartProducts\Domain\Repository\Product\ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Extcode\CartProducts\Domain\Repository\CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(
        \Extcode\CartProducts\Domain\Repository\CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Action initializer
     */
    protected function initializeAction()
    {
        $this->pluginSettings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        $pageId = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');

        $frameworkConfiguration =
            $this->configurationManager->getConfiguration(
                \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            );
        $persistenceConfiguration = ['persistence' => ['storagePid' => $pageId]];
        $this->configurationManager->setConfiguration(
            array_merge($frameworkConfiguration, $persistenceConfiguration)
        );

        $arguments = $this->request->getArguments();
        if ($arguments['search']) {
            $this->searchArguments = $arguments['search'];
        }
    }

    /**
     * Create the demand object which define which records will get shown
     *
     * @param array $settings
     *
     * @return \Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand
     */
    protected function createDemandObjectFromSettings($settings)
    {
        /** @var \Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand $demand */
        $demand = $this->objectManager->get(
            \Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand::class
        );

        if ($this->searchArguments['sku']) {
            $demand->setSku($this->searchArguments['sku']);
        }
        if ($this->searchArguments['title']) {
            $demand->setTitle($this->searchArguments['title']);
        }
        if ($settings['orderBy']) {
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    /**
     * @param \Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand $demand
     */
    protected function addCategoriesToDemandObjectFromSettings(&$demand)
    {
        if ($this->settings['categoriesList']) {
            $selectedCategories = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(
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

    /**
     * action list
     */
    public function listAction()
    {
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $products = $this->productRepository->findDemanded($demand);

        $this->view->assign('searchArguments', $this->searchArguments);
        $this->view->assign('products', $products);

        $this->view->assign('returnUrl', rawurlencode(BackendUtility::getModuleUrl('Cart_CartProductsProducts')));
    }

    /**
     * action show
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $product
     *
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $product
     */
    public function showAction(\Extcode\CartProducts\Domain\Model\Product\Product $product = null)
    {
        if (empty($product)) {
            $this->forward('list');
        }

        $this->view->assign('user', $GLOBALS['TSFE']->fe_user->user);
        $this->view->assign('product', $product);
    }
}
