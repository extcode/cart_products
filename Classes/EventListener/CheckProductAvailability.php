<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\BeVariant as CartProductBeVariant;
use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Event\CheckProductAvailabilityEvent;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\BeVariantRepository;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckProductAvailability
{
    private CheckProductAvailabilityEvent $event;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BeVariantRepository $beVariantRepository,
    ) {}

    public function __invoke(CheckProductAvailabilityEvent $event): void
    {
        $this->event = $event;
        $cartProduct = $event->getProduct();

        if ($cartProduct->getProductType() !== 'CartProducts' || $cartProduct->isHandleStock() === false) {
            return;
        }

        if ($cartProduct->isHandleStockInVariants()) {
            foreach ($cartProduct->getBeVariants() as $cartProductBeVariant) {
                $this->checkStockForBeVariant($cartProductBeVariant, $cartProduct);
            }
        } else {
            $this->checkStockForProduct($cartProduct);
        }
    }

    private function checkStockForProduct(CartProduct $cartProduct): void
    {
        $cart = $this->event->getCart();
        $mode = $this->event->getMode();

        $quantity = $this->event->getQuantity();
        if (is_array($quantity)) {
            $compareQuantity = array_sum($quantity);
        } else {
            $compareQuantity = (int)$quantity;
        }

        if (($mode === 'add') && $cart->getProductById($cartProduct->getId())) {
            $compareQuantity += $cart->getProductById($cartProduct->getId())->getQuantity();
        }

        $currentStock = $this->productRepository->getStock($cartProduct->getProductId());

        if ($compareQuantity > $currentStock) {
            $this->falseAvailability();
        }
    }

    public function checkStockForBeVariant(CartProductBeVariant $cartProductBeVariant, CartProduct $cartProduct): void
    {
        $cart = $this->event->getCart();
        $mode = $this->event->getMode();

        $quantity = $this->event->getQuantity();
        if (is_array($quantity)) {
            $compareQuantity = array_sum($quantity);
        } else {
            $compareQuantity = (int)$quantity;
        }

        if (
            $mode === 'add' &&
            $cart->getProductById($cartProduct->getId()) &&
            $cart->getProductById($cartProduct->getId())->getBeVariantById($cartProductBeVariant->getId())
        ) {
            $compareQuantity += $cart->getProductById($cartProduct->getId())->getBeVariantById($cartProductBeVariant->getId())->getQuantity();
        }

        $currentStock = $this->beVariantRepository->getStock((int)$cartProductBeVariant->getId());

        if ($compareQuantity > $currentStock) {
            $this->falseAvailability();
        }
    }

    private function falseAvailability(): void
    {
        $this->event->setAvailable(false);
        $this->event->addMessage(
            GeneralUtility::makeInstance(
                FlashMessage::class,
                LocalizationUtility::translate(
                    'tx_cart.error.stock_handling.update',
                    'cart'
                ),
                '',
                ContextualFeedbackSeverity::ERROR
            )
        );
    }
}
