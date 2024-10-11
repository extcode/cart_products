<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\RetrieveProductsFromRequestEvent;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Context\Context;

class RetrieveProductsFromRequest
{
    public function __construct(
        private readonly Context $context,
        private readonly EventDispatcherInterface $eventDispatcher,
        protected ProductRepository $productRepository
    ) {}

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $taxClasses = $event->getCart()->getTaxClasses();
        $requestArguments = $request->getArguments();

        if ($requestArguments['productType'] !== 'CartProducts') {
            return;
        }

        $frontendUserGroupIds = $this->getFrontendUserGroupIds();

        $createEvent = new \Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent($request, $taxClasses);
        $createEvent->setFrontendUserGroupIds($frontendUserGroupIds);
        $this->eventDispatcher->dispatch($createEvent);

        $errors = $createEvent->getErrors();
        if (!empty($errors)) {
            $event->setErrors($errors);
            $event->setPropagationStopped(true);
            return;
        }

        $event->addProduct($createEvent->getCartProduct());
    }

    protected function getFrontendUserGroupIds(): array
    {
        return $this->context->getPropertyFromAspect('frontend.user', 'groupIds') ?? [];
    }
}
