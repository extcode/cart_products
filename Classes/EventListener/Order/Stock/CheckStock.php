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
use Extcode\Cart\Event\ProcessOrderCheckStockEvent;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\BeVariantRepository;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckStock
{
    private ProcessOrderCheckStockEvent $event;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BeVariantRepository $beVariantRepository,
    ) {}

    public function __invoke(ProcessOrderCheckStockEvent $event): void
    {
        $this->event = $event;
        $cart = $event->getCart();
        $cartProducts = $cart->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() !== 'CartProducts' || $cartProduct->isHandleStock() === false) {
                continue;
            }

            if ($cartProduct->isHandleStockInVariants()) {
                foreach ($cartProduct->getBeVariants() as $cartProductBeVariant) {
                    $this->checkStockForBackendVariant($cartProductBeVariant, $cartProduct);
                }
            } else {
                $this->checkStockForProduct($cartProduct);
            }
        }
    }

    private function checkStockForProduct(CartProduct $cartProduct): void
    {
        $quantityInStock = $this->productRepository->getStock($cartProduct->getProductId());

        if ($quantityInStock < $cartProduct->getQuantity()) {
            $this->falseAvailability($cartProduct->getTitle(), $cartProduct->getSku(), $quantityInStock);
        }
    }

    public function checkStockForBackendVariant(CartProductBeVariant $cartProductBeVariant, CartProduct $cartProduct): void
    {
        $quantityInStock = $this->beVariantRepository->getStock((int)$cartProductBeVariant->getId());

        if ($quantityInStock < $cartProductBeVariant->getQuantity()) {
            $this->falseAvailability($cartProduct->getTitle(), $cartProductBeVariant->getSku(), $quantityInStock);
        }
    }

    private function falseAvailability(
        string $title,
        string $sku,
        int $quantityInStock
    ): void {
        $this->event->setNotEveryProductAvailable();
        $this->event->addInsufficientStockMessage(
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
