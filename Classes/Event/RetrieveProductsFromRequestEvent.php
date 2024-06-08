<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Event;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\FeVariant as CartFeVariant;
use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\CartProducts\Domain\Model\Product\Product as ProductProduct;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\Request;

final class RetrieveProductsFromRequestEvent implements RetrieveProductsFromRequestEventInterface
{
    private ?ProductProduct $productProduct = null;

    private ?CartProduct $cartProduct = null;

    private ?CartFeVariant $cartFeVariant = null;

    private array $frontendUserGroupIds = [];

    /**
     * @var FlashMessage[]
     */
    private array $errors = [];

    private bool $isPropagationStopped = false;

    public function __construct(
        private readonly Request $request,
        private readonly array $taxClasses
    ) {}

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getTaxClasses(): array
    {
        return $this->taxClasses;
    }

    public function getProductProduct(): ?ProductProduct
    {
        return $this->productProduct;
    }

    public function setProductProduct(ProductProduct $productProduct): void
    {
        $this->productProduct = $productProduct;
    }

    public function getCartProduct(): ?CartProduct
    {
        return $this->cartProduct;
    }

    public function setCartProduct(CartProduct $cartProduct): void
    {
        $this->cartProduct = $cartProduct;
    }

    public function getCartFeVariant(): ?CartFeVariant
    {
        return $this->cartFeVariant;
    }

    public function setCartFeVariant(CartFeVariant $cartFeVariant): void
    {
        $this->cartFeVariant = $cartFeVariant;
    }

    public function getFrontendUserGroupIds(): array
    {
        return $this->frontendUserGroupIds;
    }

    public function setFrontendUserGroupIds(array $frontendUserGroupIds): void
    {
        $this->frontendUserGroupIds = $frontendUserGroupIds;
    }

    public function addError(FlashMessage $error): void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function setPropagationStopped(bool $isPropagationStopped): void
    {
        $this->isPropagationStopped = $isPropagationStopped;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }
}
