<?php
declare(strict_types=1);
namespace Extcode\CartProducts\Utility;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Stock Utility
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class StockUtility
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * MailHandler constructor
     */
    public function __construct()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );

        $this->logManager = $this->objectManager->get(
            \TYPO3\CMS\Core\Log\LogManager::class
        );

        $this->persistenceManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class
        );

        $this->configurationManager = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class
        );

        $this->config = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'CartProducts'
        );
    }

    public function handleStock($params)
    {
        $cartProduct = $params['cartProduct'];

        if ($cartProduct->getProductType() == 'CartProducts') {
            /** @var \Extcode\Cart\Domain\Repository\Product\ProductRepository $productRepository */
            $productRepository = $this->objectManager->get(
                \Extcode\CartProducts\Domain\Repository\Product\ProductRepository::class
            );
            /** @var \Extcode\Cart\Domain\Repository\Product\BeVariantRepository $beVariantRepository */
            $beVariantRepository = $this->objectManager->get(
                \Extcode\CartProducts\Domain\Repository\Product\BeVariantRepository::class
            );

            $product = $productRepository->findByUid($cartProduct->getProductId());
            if ($product->isHandleStock()) {
                if ($product->isHandleStockInVariants()) {
                    /** @var \Extcode\Cart\Domain\Model\Cart\BeVariant $cartBeVariant */
                    foreach ($cartProduct->getBeVariants() as $cartBeVariant) {
                        /** @var \Extcode\Cart\Domain\Model\Product\BeVariant $productBeVariant */
                        $productBeVariant = $beVariantRepository->findByUid($cartBeVariant->getId());
                        $productBeVariant->removeFromStock($cartBeVariant->getQuantity());
                        $beVariantRepository->update($productBeVariant);
                    }
                } else {
                    $product->removeFromStock($cartProduct->getQuantity());
                    $productRepository->update($product);
                }

                $this->persistenceManager->persistAll();

                $this->flushCache($product->getUid());
            }
        }
    }

    /**
     * @param int $productId
     */
    protected function flushCache(int $productId)
    {
        $cacheTag = 'tx_cartproducts_product_' . $productId;

        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

        $cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
    }
}
