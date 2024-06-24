<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\ProcessOrderCheckStockEvent;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ProcessOrderCheckStock
{
    public function __construct(
        protected readonly ProductRepository $productRepository
    ) {}

    public function __invoke(ProcessOrderCheckStockEvent $event): void
    {
        $cart = $event->getCart();
        $cartProducts = $cart->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() !== 'CartProducts') {
                continue;
            }

            $querySettings = $this->productRepository->createQuery()->getQuerySettings();
            $querySettings->setRespectStoragePage(false);
            $this->productRepository->setDefaultQuerySettings($querySettings);
            $product = $this->productRepository->findByIdentifier($cartProduct->getProductId());

            if (!$product instanceof Product || !$product->isHandleStock()) {
                continue;
            }

            $compareQuantity = $cartProduct->getQuantity();

            if (!$product->isHandleStockInVariants()) {
                $quantityInStock = $product->getStock();
                if ($compareQuantity > $quantityInStock) {
                    $this->falseAvailability($event, $product->getTitle(), $product->getSku(), $quantityInStock);
                }
                continue;
            }

            foreach ($product->getBeVariants() as $beVariant) {
                foreach ($cartProduct->getBeVariants() as $cartBeVariant) {
                    if ($cartBeVariant->getSku() !== $beVariant->getSku()) {
                        continue;
                    }
                    $quantityInStock = $beVariant->getStock();
                    if ($compareQuantity > $quantityInStock) {
                        $this->falseAvailability($event, $product->getTitle(), $beVariant->getSku(), $quantityInStock);
                    }
                }
            }
        }
    }

    protected function falseAvailability(
        ProcessOrderCheckStockEvent $event,
        string $title,
        string $sku,
        int $quantityInStock
    ): void {
        $event->setNotEveryProductAvailable();
        $event->addInsufficientStockMessage(
            GeneralUtility::makeInstance(
                FlashMessage::class,
                LocalizationUtility::translate(
                    'tx_cart.error.stock_handling.order',
                    'cart',
                    [$title, $sku, $quantityInStock]
                ),
                '',
                ContextualFeedbackSeverity::ERROR
            )
        );
    }
}
