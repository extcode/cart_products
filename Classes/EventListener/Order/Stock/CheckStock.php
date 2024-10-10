<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Event\ProcessOrderCheckStockEvent;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CheckStock
{
    private ProcessOrderCheckStockEvent $event;

    public function __construct(
        protected readonly ProductRepository $productRepository
    ) {
        $querySettings = $this->productRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->productRepository->setDefaultQuerySettings($querySettings);
    }

    public function __invoke(ProcessOrderCheckStockEvent $event): void
    {
        $this->event = $event;
        $cart = $event->getCart();
        $cartProducts = $cart->getProducts();

        /** @var CartProduct $cartProduct */
        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() !== 'CartProducts') {
                continue;
            }

            $warehouseProduct = $this->getWarehouseProduct($cartProduct->getProductId());

            if (!$warehouseProduct instanceof Product || !$warehouseProduct->isHandleStock()) {
                continue;
            }

            $quantityToSell = $cartProduct->getQuantity();

            if ($this->stockHandlingNotInVariant($warehouseProduct, $quantityToSell)) {
                continue;
            }

            $this->stockHandlingInVariant($warehouseProduct, $cartProduct, $quantityToSell);
        }
    }

    private function getWarehouseProduct(int $productId): null|DomainObjectInterface
    {

        return $this->productRepository->findByIdentifier($productId);
    }

    private function stockHandlingNotInVariant(Product $product, int $quantityToSell): bool
    {
        if (!$product->isHandleStockInVariants()) {
            $quantityInStock = $product->getStock();

            if ($quantityToSell > $quantityInStock) {
                $this->falseAvailability($this->event, $product->getTitle(), $product->getSku(), $quantityInStock);
            }
            return true;
        }

        return false;
    }

    private function falseAvailability(
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

    private function stockHandlingInVariant(
        Product $productInWarehouse,
        CartProduct $cartProduct,
        int $quantityToSell
    ): void {
        foreach ($productInWarehouse->getBeVariants() as $beVariantWarehouse) {
            foreach ($cartProduct->getBeVariants() as $beVariantCart) {
                if ($beVariantCart->getSku() !== $beVariantWarehouse->getSku()) {
                    continue;
                }

                $quantityInStock = $beVariantWarehouse->getStock();

                if ($quantityToSell > $quantityInStock) {
                    $this->falseAvailability(
                        $this->event,
                        $productInWarehouse->getTitle(),
                        $beVariantWarehouse->getSku(),
                        $quantityInStock
                    );
                }
            }
        }
    }
}
