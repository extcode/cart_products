<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Event;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\CartProducts\Domain\Model\Product\Product as ProductProduct;
use Psr\EventDispatcher\StoppableEventInterface;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\Request;

interface RetrieveProductsFromRequestEventInterface extends StoppableEventInterface
{
    public function __construct(Request $request, array $taxClasses);

    public function getRequest(): Request;

    public function getCartProduct(): ?CartProduct;

    public function setCartProduct(CartProduct $cartProduct): void;

    public function getProductProduct(): ?ProductProduct;

    public function setProductProduct(ProductProduct $productProduct): void;

    public function getFrontendUserGroupIds(): array;

    public function setFrontendUserGroupIds(array $frontendUserGroupIds): void;

    public function addError(FlashMessage $error): void;

    public function getErrors(): array;

    public function setErrors(array $errors): void;
}
