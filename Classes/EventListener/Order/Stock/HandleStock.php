<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Event\Order\EventInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class HandleStock
{
    public function __invoke(EventInterface $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() === 'CartProducts') {
                $productConnection = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable('tx_cartproducts_domain_model_product_product');
                $productQueryBuilder = $productConnection->createQueryBuilder();

                $product = $productQueryBuilder
                    ->select('uid', 'handle_stock', 'handle_stock_in_variants')
                    ->from('tx_cartproducts_domain_model_product_product')->where($productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT)))->executeQuery()->fetchAssociative();

                if ($product['handle_stock']) {
                    if ($product['handle_stock_in_variants']) {
                        $this->handleStockInBeVariant($cartProduct);
                    } else {
                        $this->handleStockInProduct($cartProduct);
                    }
                }
            }
        }
    }

    protected function handleStockInProduct(CartProduct $cartProduct): void
    {
        $productConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_cartproducts_domain_model_product_product');
        $productQueryBuilder = $productConnection->createQueryBuilder();

        $product = $productQueryBuilder
            ->select('stock')
            ->from('tx_cartproducts_domain_model_product_product')->where($productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT)))->executeQuery()->fetchAssociative();

        $productQueryBuilder
            ->update('tx_cartproducts_domain_model_product_product')
            ->where(
                $productQueryBuilder->expr()->eq('uid', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
            )
            ->orWhere(
                $productQueryBuilder->expr()->eq('l10n_parent', $productQueryBuilder->createNamedParameter($cartProduct->getProductId(), \PDO::PARAM_INT))
            )->set('stock', $product['stock'] - $cartProduct->getQuantity())->executeStatement();
    }

    protected function handleStockInBeVariant(CartProduct $cartProduct): void
    {
        $beVariantConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_cartproducts_domain_model_product_bevariant');

        foreach ($cartProduct->getBeVariants() as $cartBeVariant) {
            $beVariantQueryBuilder = $beVariantConnection->createQueryBuilder();
            $beVariant = $beVariantQueryBuilder
                ->select('stock')
                ->from('tx_cartproducts_domain_model_product_bevariant')->where($beVariantQueryBuilder->expr()->eq('uid', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT)))->executeQuery()->fetchAssociative();

            $beVariantQueryBuilder
                ->update('tx_cartproducts_domain_model_product_bevariant')
                ->where(
                    $beVariantQueryBuilder->expr()->eq('uid', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT))
                )
                ->orWhere(
                    $beVariantQueryBuilder->expr()->eq('l10n_parent', $beVariantQueryBuilder->createNamedParameter($cartBeVariant->getId(), \PDO::PARAM_INT))
                )->set('stock', $beVariant['stock'] - $cartBeVariant->getQuantity())->executeStatement();
        }
    }
}
