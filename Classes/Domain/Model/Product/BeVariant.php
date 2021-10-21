<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class BeVariant extends AbstractEntity
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var BeVariantAttributeOption
     */
    protected $beVariantAttributeOption1;

    /**
     * @var BeVariantAttributeOption
     */
    protected $beVariantAttributeOption2;

    /**
     * @var BeVariantAttributeOption
     */
    protected $beVariantAttributeOption3;

    /**
     * @var float
     */
    protected $price = 0.0;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\SpecialPrice>
     */
    protected $specialPrices = null;

    /**
     * @var int
     */
    protected $priceCalcMethod = 0;

    /**
     * @var float
     */
    protected $priceMeasure = 0.0;

    /**
     * @var string
     */
    protected $priceMeasureUnit = '';

    /**
     * @var int
     */
    protected $stock = 0;

    public function __construct()
    {
        $this->specialPrices = new ObjectStorage();
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getBeVariantAttributeOption1(): ?BeVariantAttributeOption
    {
        return $this->beVariantAttributeOption1;
    }

    public function setBeVariantAttributeOption1(BeVariantAttributeOption $beVariantAttributeOption1): void
    {
        $this->beVariantAttributeOption1 = $beVariantAttributeOption1;
    }

    public function getBeVariantAttributeOption2(): ?BeVariantAttributeOption
    {
        return $this->beVariantAttributeOption2;
    }

    public function setBeVariantAttributeOption2(BeVariantAttributeOption $beVariantAttributeOption2): void
    {
        $this->beVariantAttributeOption2 = $beVariantAttributeOption2;
    }

    public function getBeVariantAttributeOption3(): ?BeVariantAttributeOption
    {
        return $this->beVariantAttributeOption3;
    }

    public function setBeVariantAttributeOption3(BeVariantAttributeOption $beVariantAttributeOption3): void
    {
        $this->beVariantAttributeOption3 = $beVariantAttributeOption3;
    }

    public function getPriceCalculated(): float
    {
        $price = $this->getPrice();

        $parentPrice = $this->getProduct()->getPrice();

        switch ($this->priceCalcMethod) {
            case 3:
                $calc_price = -1 * (($price / 100) * ($parentPrice));
                break;
            case 5:
                $calc_price = ($price / 100) * ($parentPrice);
                break;
            default:
                $calc_price = 0;
        }

        if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['changeVariantDiscount']) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['changeVariantDiscount'] as $funcRef) {
                if ($funcRef) {
                    $params = [
                        'price_calc_method' => $this->priceCalcMethod,
                        'price' => &$price,
                        'parent_price' => &$parentPrice,
                        'calc_price' => &$calc_price,
                    ];

                    GeneralUtility::callUserFunction($funcRef, $params, $this);
                }
            }
        }

        switch ($this->priceCalcMethod) {
            case 1:
                $parentPrice = 0.0;
                break;
            case 2:
                $price = -1 * $price;
                break;
            case 4:
                break;
            default:
                $price = 0.0;
        }

        return $parentPrice + $price + $calc_price;
    }

    public function getBestPriceCalculated($frontendUserGroupIds = []): float
    {
        $price = $this->getBestPrice($frontendUserGroupIds);

        $parentPrice = $this->getProduct()->getBestSpecialPrice($frontendUserGroupIds);

        switch ($this->priceCalcMethod) {
            case 3:
                $calc_price = -1 * (($price / 100) * ($parentPrice));
                break;
            case 5:
                $calc_price = ($price / 100) * ($parentPrice);
                break;
            default:
                $calc_price = 0;
        }

        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['changeVariantDiscount'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cart']['changeVariantDiscount'] as $funcRef) {
                if ($funcRef) {
                    $params = [
                        'price_calc_method' => $this->priceCalcMethod,
                        'price' => &$price,
                        'parent_price' => &$parentPrice,
                        'calc_price' => &$calc_price,
                    ];

                    GeneralUtility::callUserFunction($funcRef, $params, $this);
                }
            }
        }

        switch ($this->priceCalcMethod) {
            case 1:
                $parentPrice = 0.0;
                break;
            case 2:
                $price = -1 * $price;
                break;
            case 4:
                break;
            default:
                $price = 0.0;
        }

        return $parentPrice + $price + $calc_price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPriceCalcMethod(): int
    {
        return $this->priceCalcMethod;
    }

    public function setPriceCalcMethod(int $priceCalcMethod): void
    {
        $this->priceCalcMethod = $priceCalcMethod;
    }

    public function addSpecialPrice(SpecialPrice $specialPrice): void
    {
        $this->specialPrices->attach($specialPrice);
    }

    public function removeSpecialPrice(SpecialPrice $specialPrice): void
    {
        $this->specialPrices->detach($specialPrice);
    }

    /**
     * @return ObjectStorage<SpecialPrice>
     */
    public function getSpecialPrices(): ObjectStorage
    {
        return $this->specialPrices;
    }

    public function setSpecialPrices(ObjectStorage $specialPrices): void
    {
        $this->specialPrices = $specialPrices;
    }

    public function getBestSpecialPrice(array $frontendUserGroupIds = []): ?SpecialPrice
    {
        /** @var SpecialPrice $bestSpecialPrice */
        $bestSpecialPrice = null;

        if ($this->getSpecialPrices()) {
            foreach ($this->getSpecialPrices() as $specialPrice) {
                if ($bestSpecialPrice === null) {
                    if (!$specialPrice->getFrontendUserGroup() ||
                        in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                    ) {
                        $bestSpecialPrice = $specialPrice;
                    }
                    continue;
                }

                if (
                    (
                        ($specialPrice->getPrice() < $bestSpecialPrice->getPrice()) &&
                        in_array($this->priceCalcMethod, [0, 1, 4, 5])
                    ) ||
                    (
                        ($specialPrice->getPrice() > $bestSpecialPrice->getPrice()) &&
                        in_array($this->priceCalcMethod, [2, 3])
                    )
                ) {
                    if (!$specialPrice->getFrontendUserGroup() ||
                        in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                    ) {
                        $bestSpecialPrice = $specialPrice;
                    }
                }
            }
        }

        return $bestSpecialPrice;
    }

    public function getBestPrice(array $frontendUserGroupIds = []): float
    {
        $bestPrice = $this->price;
        $bestSpecialPrice = $this->getBestSpecialPrice($frontendUserGroupIds);

        if ($bestSpecialPrice) {
            if (
                (
                    ($bestSpecialPrice->getPrice() < $bestPrice) &&
                    in_array($this->priceCalcMethod, [0, 1, 4, 5])
                ) ||
                (
                    ($bestSpecialPrice->getPrice() > $bestPrice) &&
                    in_array($this->priceCalcMethod, [2, 3])
                )
            ) {
                $bestPrice = $bestSpecialPrice->getPrice();
            }
        }

        return $bestPrice;
    }

    public function getBestSpecialPriceDiscount(array $frontendUserGroupIds = []): float
    {
        $bestSpecialPrice = $this->getBestPriceCalculated($frontendUserGroupIds);
        $bestSpecialPriceDiscount = $this->getPriceCalculated() - $bestSpecialPrice;

        return $bestSpecialPriceDiscount;
    }

    public function getBestSpecialPricePercentageDiscount(array $frontendUserGroupIds = []): float
    {
        if ($this->getPriceCalculated() !== 0) {
            $bestSpecialPricePercentageDiscount = (($this->getBestSpecialPriceDiscount($frontendUserGroupIds)) / $this->getPriceCalculated()) * 100;
        }

        return $bestSpecialPricePercentageDiscount;
    }

    public function getBasePrice(): ?float
    {
        //TODO: respects different measuring units between variant and product
        if (!$this->getProduct()->getBasePriceMeasure() > 0) {
            return null;
        }
        if (!$this->getPriceMeasure() > 0) {
            return null;
        }
        $ratio = $this->getProduct()->getBasePriceMeasure() / $this->getPriceMeasure();

        $price = round($this->price * $ratio * 100.0) / 100.0;

        return $price;
    }

    public function getPriceMeasure(): float
    {
        return $this->priceMeasure;
    }

    public function setPriceMeasure(float $priceMeasure): void
    {
        $this->priceMeasure = $priceMeasure;
    }

    public function getPriceMeasureUnit(): string
    {
        return $this->priceMeasureUnit;
    }

    public function setPriceMeasureUnit(string $priceMeasureUnit): void
    {
        $this->priceMeasureUnit = $priceMeasureUnit;
    }

    public function getIsMeasureUnitCompatibility(): bool
    {
        foreach ($this->product->getMeasureUnits() as $measureUnit) {
            if (array_key_exists($this->product->getBasePriceMeasureUnit(), $measureUnit)
                && array_key_exists($this->priceMeasureUnit, $measureUnit)
            ) {
                return true;
            }
        }

        return false;
    }

    public function getMeasureUnitFactor(): float
    {
        $factor = 1.0;

        foreach ($this->product->getMeasureUnits() as $measureUnit) {
            if ($measureUnit[$this->priceMeasureUnit]) {
                $factor = $factor / ($this->priceMeasure / $measureUnit[$this->priceMeasureUnit]);
            }
            if ($measureUnit[$this->product->getBasePriceMeasureUnit()]) {
                $factor = $factor * (1 / $measureUnit[$this->product->getBasePriceMeasureUnit()]);
            }
        }

        return $factor;
    }

    /**
     * @return float|bool
     */
    public function getCalculatedBasePrice()
    {
        if ($this->getIsMeasureUnitCompatibility()) {
            return $this->getBestPriceCalculated() * $this->getMeasureUnitFactor();
        }

        return false;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function addToStock(int $stock): void
    {
        $this->stock += $stock;
    }

    public function removeFromStock(int $stock): void
    {
        $this->stock -= $stock;
    }

    public function getIsAvailable(): bool
    {
        return boolval($this->stock);
    }

    public function getSku(): string
    {
        $skuArray = [];

        if ($this->getProduct()->getBeVariantAttribute1()) {
            $skuArray[] = $this->getProduct()->getBeVariantAttribute1()->getSku();
            $skuArray[] = $this->getBeVariantAttributeOption1()->getSku();
        }

        if ($this->getProduct()->getBeVariantAttribute2()) {
            $skuArray[] = $this->getProduct()->getBeVariantAttribute2()->getSku();
            $skuArray[] = $this->getBeVariantAttributeOption2()->getSku();
        }

        if ($this->getProduct()->getBeVariantAttribute3()) {
            $skuArray[] = $this->getProduct()->getBeVariantAttribute3()->getSku();
            $skuArray[] = $this->getBeVariantAttributeOption3()->getSku();
        }

        return implode('-', $skuArray);
    }

    public function getTitle(): string
    {
        $titleArray = [];

        if ($this->getProduct()->getBeVariantAttribute1()) {
            $titleArray[] =
                $this->getProduct()->getBeVariantAttribute1()->getTitle()
                . ' '
                . $this->getBeVariantAttributeOption1()->getTitle();
        }
        if ($this->getProduct()->getBeVariantAttribute2()) {
            $titleArray[] =
                $this->getProduct()->getBeVariantAttribute2()->getTitle()
                . ' '
                . $this->getBeVariantAttributeOption2()->getTitle();
        }
        if ($this->getProduct()->getBeVariantAttribute3()) {
            $titleArray[] =
                $this->getProduct()->getBeVariantAttribute3()->getTitle()
                . ' '
                . $this->getBeVariantAttributeOption3()->getTitle();
        }

        return implode(' - ', $titleArray);
    }
}
