<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Create;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\ProductFactoryInterface;
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent;

final class CreateCartProduct
{
    public function __construct(
        private ProductFactoryInterface $productFactory
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $productProduct = $event->getProductProduct();
        $taxClasses = $event->getTaxClasses();
        $frontendUserGroupIds = $event->getFrontendUserGroupIds();

        $cartProduct = $this->productFactory->create(
            'CartProducts',
            (int)$request->getArgument('product'),
            $productProduct->getSku(),
            $productProduct->getTitle(),
            $productProduct->getPrice(),
            $taxClasses[$productProduct->getTaxClassId()],
            (int)$request->getArgument('quantity'),
            $productProduct->getIsNetPrice(),
            $event->getCartFeVariant()
        );

        $cartProduct->setMaxNumberInCart($productProduct->getMaxNumberInOrder());
        $cartProduct->setMinNumberInCart($productProduct->getMinNumberInOrder());

        $cartProduct->setSpecialPrice($productProduct->getBestSpecialPrice($frontendUserGroupIds));
        $cartProduct->setQuantityDiscounts($productProduct->getQuantityDiscountArray($frontendUserGroupIds));

        $cartProduct->setStock($productProduct->getStock());
        $cartProduct->setHandleStock($productProduct->isHandleStock());
        $cartProduct->setHandleStockInVariants($productProduct->isHandleStockInVariants());

        $cartProduct->setServiceAttribute1($productProduct->getServiceAttribute1());
        $cartProduct->setServiceAttribute2($productProduct->getServiceAttribute2());
        $cartProduct->setServiceAttribute3($productProduct->getServiceAttribute3());

        if ($productProduct->getProductType() === 'virtual' || $productProduct->getProductType() === 'downloadable') {
            $cartProduct->setIsVirtualProduct(true);
        }

        $event->setCartProduct($cartProduct);
    }
}
