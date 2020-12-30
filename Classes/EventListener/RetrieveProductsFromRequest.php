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
use Extcode\CartProducts\Utility\ProductUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class RetrieveProductsFromRequest
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProductUtility
     */
    protected $productUtility;

    public function __construct(
        ProductRepository $productRepository,
        ProductUtility $productUtility
    ) {
        $this->productRepository = $productRepository;
        $this->productUtility = $productUtility;
    }

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $cart = $event->getCart();
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        $errors = $this->checkRequestArguments($requestArguments);

        if (!empty($errors)) {
            $event->setErrors($errors);
            return;
        }

        $this->productUtility->setTaxClasses($taxClasses);

        $event->addProduct(
            $this->productUtility->getProductFromRequest(
                $request,
                $cart->getTaxClasses()
            )
        );
    }

    protected function checkRequestArguments(array $requestArguments): array
    {
        if (!(int)$requestArguments['product']) {
            return [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cart.error.parameter.no_product',
                    'cart_products'
                ),
                AbstractMessage::ERROR
            ];
        }

        if ((int)$requestArguments['quantity'] < 0) {
            return [
                'messageBody' => LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'cart_products'
                ),
                'severity' => AbstractMessage::WARNING
            ];
        }

        return [];
    }
}
