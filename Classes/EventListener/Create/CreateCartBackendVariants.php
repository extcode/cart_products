<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Create;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\BeVariantFactoryInterface;
use Extcode\Cart\Domain\Model\Cart\BeVariantInterface;
use Extcode\Cart\Domain\Model\Cart\ProductInterface;
use Extcode\CartProducts\Domain\Model\Product\SpecialPrice;
use Extcode\CartProducts\Domain\Repository\Product\BeVariantRepository;
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent;

final class CreateCartBackendVariants
{
    private array $frontendUserGroupIds;

    public function __construct(
        private BeVariantRepository $beVariantRepository,
        private BeVariantFactoryInterface $beVariantFactory
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $this->frontendUserGroupIds = $event->getFrontendUserGroupIds();

        if (!$request->hasArgument('beVariants')) {
            return;
        }
        $requestBeVariants = $request->getArgument('beVariants');
        $quantity = (int)($request->getArgument('quantity')) ?: 1;

        $cartProduct = $event->getCartProduct();

        if ($requestBeVariants) {
            $newVariantArr = [];

            foreach ($requestBeVariants as $variantsKey => $variantId) {
                if ($variantsKey === 1) {
                    $newVariant = $this->createCartBackendVariant(
                        $quantity,
                        $variantId,
                        $cartProduct
                    );

                    if ($newVariant) {
                        $newVariantArr[$variantsKey] = $newVariant;
                        $cartProduct->addBeVariant($newVariant);
                    } else {
                        break;
                    }
                } else {
                    $newVariant = $this->createCartBackendVariant(
                        $quantity,
                        $variantId,
                        $newVariantArr[$variantsKey - 1]
                    );

                    if ($newVariant) {
                        $newVariantArr[$variantsKey] = $newVariant;
                        $newVariantArr[$variantsKey - 1]->addBeVariant($newVariant);
                    } else {
                        break;
                    }
                }
            }
        }
    }

    protected function createCartBackendVariant(
        int $quantity,
        string $variantId,
        BeVariantInterface|ProductInterface $parent,
    ): ?BeVariantInterface {
        $productBackendVariant = $this->beVariantRepository->findByUid($variantId);

        if (!$productBackendVariant instanceof \Extcode\CartProducts\Domain\Model\Product\BeVariant) {
            return null;
        }

        $cartBackendVariant = $this->beVariantFactory->create(
            $variantId,
            $parent,
            $productBackendVariant->getTitle(),
            $productBackendVariant->getSku(),
            $productBackendVariant->getPriceCalcMethod(),
            $productBackendVariant->getPrice(),
            $quantity
        );

        $bestSpecialPrice = $productBackendVariant->getBestSpecialPrice($this->frontendUserGroupIds);
        if ($bestSpecialPrice instanceof SpecialPrice) {
            $cartBackendVariant->setSpecialPrice($bestSpecialPrice->getPrice());
        }

        $cartBackendVariant->setStock($productBackendVariant->getStock());

        return $cartBackendVariant;
    }
}
