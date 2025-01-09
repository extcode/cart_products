<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Create;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\FeVariantFactoryInterface;
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent;

final class CreateCartFrontendVariants
{
    public function __construct(
        private FeVariantFactoryInterface $feVariantFactory
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$request->hasArgument('feVariants')) {
            return;
        }

        $productProductFeVariants = $event->getProductProduct()->getFeVariants();

        if ($productProductFeVariants->count() === 0) {
            return;
        }

        $requestFeVariants = $request->getArgument('feVariants');

        $cartProductFeVariants = [];

        foreach ($productProductFeVariants as $feVariant) {
            if ($requestFeVariants[$feVariant->getSku()]) {
                $cartProductFeVariants[] = [
                    'sku' => $feVariant->getSku(),
                    'title' => $feVariant->getTitle(),
                    'value' => $requestFeVariants[$feVariant->getSku()],
                ];
            }
        }

        if ($cartProductFeVariants) {
            $feVariant = $this->feVariantFactory->create(
                $cartProductFeVariants
            );
            $event->setCartFeVariant($feVariant);
        }
    }
}
