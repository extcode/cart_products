<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Create;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckRequest
{
    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();

        if (
            !$request->hasArgument('product') ||
            !(int)$request->getArgument('product')
        ) {
            $event->addError(
                new FlashMessage(
                    LocalizationUtility::translate(
                        'tx_cart.error.parameter.no_product',
                        'CartProducts'
                    ),
                    '',
                    ContextualFeedbackSeverity::ERROR
                )
            );
            $event->setPropagationStopped(true);
        }

        if (
            !$request->hasArgument('quantity') ||
            $request->getArgument('quantity') < 0
        ) {
            $event->addError(
                new FlashMessage(
                    LocalizationUtility::translate(
                        'tx_cart.error.invalid_quantity',
                        'CartProducts'
                    ),
                    '',
                    ContextualFeedbackSeverity::WARNING
                )
            );
            $event->setPropagationStopped(true);
        }

        return;
    }
}
