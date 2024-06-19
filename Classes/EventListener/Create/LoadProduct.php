<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Create;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

class LoadProduct
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();

        $productId = (int)($request->getArgument('product'));
        $product = $this->productRepository->findByUid($productId);

        if (!$product) {
            $event->addError(
                new FlashMessage(
                    'product not found',
                    '',
                    ContextualFeedbackSeverity::ERROR
                )
            );

            $event->setPropagationStopped(true);
            return;
        }

        $event->setProductProduct($product);
    }
}
