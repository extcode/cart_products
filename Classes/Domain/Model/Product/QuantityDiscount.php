<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class QuantityDiscount extends AbstractEntity
{
    /**
     * @Validate("NotEmpty")
     */
    protected float $price = 0.0;

    /**
     * Quantity (lower bound)
     *
     * @Validate("NotEmpty")
     */
    protected int $quantity = 0;

    protected ?FrontendUserGroup $frontendUserGroup = null;

    public function toArray(): array
    {
        return [
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getFrontendUserGroup(): ?FrontendUserGroup
    {
        return $this->frontendUserGroup;
    }

    public function setFrontendUserGroup(FrontendUserGroup $frontendUserGroup): void
    {
        $this->frontendUserGroup = $frontendUserGroup;
    }
}
