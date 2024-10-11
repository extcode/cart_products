<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\BeVariant as CartProductBeVariant;
use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Event\Order\EventInterface;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\BeVariantRepository;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;

class HandleStock
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BeVariantRepository $beVariantRepository,
    ) {}

    public function __invoke(EventInterface $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() !== 'CartProducts' || $cartProduct->isHandleStock() === false) {
                continue;
            }

            if ($cartProduct->isHandleStockInVariants()) {
                foreach ($cartProduct->getBeVariants() as $cartProductBeVariant) {
                    $this->handleStockInBeVariant($cartProductBeVariant);
                }
            } else {
                $this->handleStockInProduct($cartProduct);
            }
        }
    }

    private function handleStockInProduct(CartProduct $cartProduct): void
    {
        $quantityToAdd = -1 * ($cartProduct->getQuantity());
        $this->productRepository->addQuantityToStock($cartProduct->getProductId(), $quantityToAdd);
    }

    private function handleStockInBeVariant(CartProductBeVariant $cartProductBeVariant): void
    {
        $quantityToAdd = -1 * ($cartProductBeVariant->getQuantity());
        $this->beVariantRepository->addQuantityToStock((int)$cartProductBeVariant->getId(), $quantityToAdd);
    }
}
