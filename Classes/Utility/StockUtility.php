<?php
declare(strict_types=1);
namespace Extcode\CartProducts\Utility;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

        if ($cartProduct->getProductType() === 'CartProducts') {
            $productConnection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_cartproducts_domain_model_product_product');
            $productQueryBuilder = $productConnection->createQueryBuilder();

            $product = $productQueryBuilder
                ->select('uid', 'handle_stock', 'handle_stock_in_variants')
                ->from('tx_cartproducts_domain_model_product_product')
                ->where(
                    $productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
                )
                ->execute()->fetch();

            if ($product['handle_stock']) {
                if ($product['handle_stock_in_variants']) {
                    $this->handleStockInBeVariant($cartProduct);
                } else {
                    $this->handleStockInProduct($cartProduct);
                }

                $this->flushCache($product['uid']);
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

    /**
     * @param \Extcode\Cart\Domain\Model\Cart\Product $cartProduct
     */
    protected function handleStockInProduct(\Extcode\Cart\Domain\Model\Cart\Product $cartProduct): void
    {
        $productConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_cartproducts_domain_model_product_product');
        $productQueryBuilder = $productConnection->createQueryBuilder();

        $product = $productQueryBuilder
            ->select('stock')
            ->from('tx_cartproducts_domain_model_product_product')
            ->where(
                $productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
            )
            ->execute()->fetch();

        $productQueryBuilder
            ->update('tx_cartproducts_domain_model_product_product')
            ->where(
                $productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
            )
            ->orWhere(
                $productQueryBuilder->expr()->eq('l10n_parent', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
            )
            ->set('stock', $product['stock'] - $cartProduct->getQuantity())
            ->execute();
    }

    /**
     * @param \Extcode\Cart\Domain\Model\Cart\Product $cartProduct
     */
    protected function handleStockInBeVariant(\Extcode\Cart\Domain\Model\Cart\Product $cartProduct): void
    {
        $beVariantConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_cartproducts_domain_model_product_bevariant');

        foreach ($cartProduct->getBeVariants() as $cartBeVariant) {
            $beVariantQueryBuilder = $beVariantConnection->createQueryBuilder();
            $beVariant = $beVariantQueryBuilder
                ->select('stock')
                ->from('tx_cartproducts_domain_model_product_bevariant')
                ->where(
                    $beVariantQueryBuilder->expr()->eq('uid', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT))
                )
                ->execute()->fetch();

            $beVariantQueryBuilder
                ->update('tx_cartproducts_domain_model_product_bevariant')
                ->where(
                    $beVariantQueryBuilder->expr()->eq('uid', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT))
                )
                ->orWhere(
                    $beVariantQueryBuilder->expr()->eq('l10n_parent', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT))
                )
                ->set('stock', $beVariant['stock'] - $cartBeVariant->getQuantity())
                ->execute();
        }
    }
}
