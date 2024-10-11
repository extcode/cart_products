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
        // $quantity is an array in the case that the amount of a product with variants is updated within the shopping
        // cart. In this case, the number from the update request must be added up, as stock management for all variants
        // together takes place in the product.
        // $quantity is not an array if a product or a product variant is added via the product page. In this case, the
        // value for the quantity must be taken directly.
        if (is_array($quantity)) {
            $quantityInCart = array_sum($quantity);
        } else {
            $quantityInCart = (int)$quantity;
        }

        if (($mode === 'add') && $cart->getProductById($cartProduct->getId())) {
            $quantityInCart += $cart->getProductById($cartProduct->getId())->getQuantity();
        }

        $quantityInStock = $this->productRepository->getStock($cartProduct->getProductId());

        if ($quantityInStock < $quantityInCart) {
            $this->falseAvailability();
        }
    }

    public function checkStockForBeVariant(CartProductBeVariant $cartProductBeVariant, CartProduct $cartProduct): void
    {
        $cart = $this->event->getCart();
        $mode = $this->event->getMode();

        $quantity = $this->event->getQuantity();
        // $quantity is an array in the case that the amount of a product with variants is updated within the shopping
        // cart. In this case, the correct quantity from the update request must be used.
        // $quantity is not an array if a variant is added via the product page. In this case, the value for the
        // quantity must be taken directly.
        if (is_array($quantity)) {
            $quantityInCart = (int)$quantity[$cartProductBeVariant->getId()];
        } else {
            $quantityInCart = (int)$quantity;
        }

        if (
            $mode === 'add' &&
            $cart->getProductById($cartProduct->getId()) &&
            $cart->getProductById($cartProduct->getId())->getBeVariantById($cartProductBeVariant->getId())
        ) {
            $quantityInCart += $cart->getProductById($cartProduct->getId())->getBeVariantById($cartProductBeVariant->getId())->getQuantity();
        }

        $quantityInStock = $this->beVariantRepository->getStock((int)$cartProductBeVariant->getId());

        if ($quantityInStock < $quantityInCart) {
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
