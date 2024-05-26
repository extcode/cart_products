<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\CheckProductAvailabilityEvent;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckProductAvailability
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function __invoke(CheckProductAvailabilityEvent $event): void
    {
        $cart = $event->getCart();
        $cartProduct = $event->getProduct();
        $quantity = $event->getQuantity();

        $mode = $event->getMode();

        if ($cartProduct->getProductType() !== 'CartProducts') {
            return;
        }

        $querySettings = $this->productRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->productRepository->setDefaultQuerySettings($querySettings);

        $product = $this->productRepository->findByIdentifier($cartProduct->getProductId());

        if (
            !$product instanceof Product ||
            !$product->isHandleStock()
        ) {
            return;
        }

        if (!$product->isHandleStockInVariants()) {
            if (is_array($quantity)) {
                $compareQuantity = array_sum($quantity);
            } else {
                $compareQuantity = $quantity;
            }
            if (($mode === 'add') && $cart->getProductById($cartProduct->getId())) {
                $compareQuantity += $cart->getProductById($cartProduct->getId())->getQuantity();
            }

            if ($compareQuantity > $product->getStock()) {
                $this->falseAvailability($event);
            }

            return;
        }

        $compareQuantity = (int)$quantity;

        foreach ($cartProduct->getBeVariants() as $beVariant) {
            if (
                $mode === 'add' &&
                $cart->getProductById($cartProduct->getId()) &&
                $cart->getProductById($cartProduct->getId())->getBeVariantById($beVariant->getId())
            ) {
                $compareQuantity += (int)$cart->getProductById($cartProduct->getId())->getBeVariantById($beVariant->getId())->getQuantity();
            }

            if ($compareQuantity > $beVariant->getStock()) {
                $this->falseAvailability($event);
            }
        }
    }

    /**
     * @param CheckProductAvailabilityEvent $event
     */
    protected function falseAvailability(CheckProductAvailabilityEvent $event): void
    {
        $event->setAvailable(false);
        $event->addMessage(
            GeneralUtility::makeInstance(
                FlashMessage::class,
                LocalizationUtility::translate(
                    'tx_cart.error.stock_handling.update',
                    'cart'
                ),
                '',
                AbstractMessage::ERROR
            )
        );
    }
}
