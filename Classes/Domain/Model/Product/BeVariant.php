<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product;

class BeVariant extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Product
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\Product
     */
    protected $product = null;

    /**
     * Variant Attribute 1
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption
     */
    protected $beVariantAttributeOption1 = null;

    /**
     * Variant Attribute 2
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption
     */
    protected $beVariantAttributeOption2 = null;

    /**
     * Variant Attribute 3
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption
     */
    protected $beVariantAttributeOption3 = null;

    /**
     * Price
     *
     * @var float
     */
    protected $price = 0.0;

    /**
     * Product Special Price
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\SpecialPrice>
     */
    protected $specialPrices = null;

    /**
     * Price Calc Method
     *
     * @var int
     */
    protected $priceCalcMethod = 0;

    /**
     * Price Measure
     *
     * @var float
     */
    protected $priceMeasure = 0.0;

    /**
     * Price Measure Unit
     *
     * @var string
     */
    protected $priceMeasureUnit = '';

    /**
     * stock
     *
     * @var int
     */
    protected $stock = 0;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->specialPrices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the Product
     *
     * @return Product\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets the Product
     *
     * @param Product\Product $product
     */
    public function setProduct(Product\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Returns the Variant Attribute 1
     *
     * @return Product\BeVariantAttributeOption
     */
    public function getBeVariantAttributeOption1()
    {
        return $this->beVariantAttributeOption1;
    }

    /**
     * Sets the Variant Attribute 1
     *
     * @param Product\BeVariantAttributeOption $beVariantAttributeOption1
     */
    public function setBeVariantAttributeOption1(
        Product\BeVariantAttributeOption $beVariantAttributeOption1
    ) {
        $this->beVariantAttributeOption1 = $beVariantAttributeOption1;
    }

    /**
     * Returns the Variant Attribute 2
     *
     * @return Product\BeVariantAttributeOption
     */
    public function getBeVariantAttributeOption2()
    {
        return $this->beVariantAttributeOption2;
    }

    /**
     * Sets the Variant Attribute 2
     *
     * @param Product\BeVariantAttributeOption $beVariantAttributeOption2
     */
    public function setBeVariantAttributeOption2(
        Product\BeVariantAttributeOption $beVariantAttributeOption2
    ) {
        $this->beVariantAttributeOption2 = $beVariantAttributeOption2;
    }

    /**
     * Returns the Variant Attribute 3
     *
     * @return Product\BeVariantAttributeOption
     */
    public function getBeVariantAttributeOption3()
    {
        return $this->beVariantAttributeOption3;
    }

    /**
     * Sets the Variant Attribute 3
     *
     * @param Product\BeVariantAttributeOption $beVariantAttributeOption3
     */
    public function setBeVariantAttributeOption3(
        Product\BeVariantAttributeOption $beVariantAttributeOption3
    ) {
        $this->beVariantAttributeOption3 = $beVariantAttributeOption3;
    }

    /**
     * Gets Price Calculated
     *
     * @return float
     */
    public function getPriceCalculated()
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

                    \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $params, $this);
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

    /**
     * Gets Price Calculated
     *
     * @return float
     */
    public function getBestPriceCalculated($frontendUserGroupIds = [])
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

                    \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($funcRef, $params, $this);
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

    /**
     * Returns the price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPriceCalcMethod()
    {
        return $this->priceCalcMethod;
    }

    /**
     * @param int $priceCalcMethod
     */
    public function setPriceCalcMethod($priceCalcMethod)
    {
        $this->priceCalcMethod = $priceCalcMethod;
    }

    /**
     * Adds a Special Price
     *
     * @param Product\SpecialPrice $specialPrice
     */
    public function addSpecialPrice(Product\SpecialPrice $specialPrice)
    {
        $this->specialPrices->attach($specialPrice);
    }

    /**
     * Removes a Special Price
     *
     * @param Product\SpecialPrice $specialPriceToRemove
     */
    public function removeSpecialPrice(Product\SpecialPrice $specialPriceToRemove)
    {
        $this->specialPrices->detach($specialPriceToRemove);
    }

    /**
     * Returns the Special Prices
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\specialPrice>
     */
    public function getSpecialPrices()
    {
        return $this->specialPrices;
    }

    /**
     * Sets the Special Prices
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $specialPrices
     */
    public function setSpecialPrices(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $specialPrices)
    {
        $this->specialPrices = $specialPrices;
    }

    /**
     * Returns Best Special Price
     *
     * @var array $frontendUserGroupIds
     *
     * @return Product\SpecialPrice
     */
    public function getBestSpecialPrice($frontendUserGroupIds = [])
    {
        /** @var Product\SpecialPrice $bestSpecialPrice */
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

    /**
     * Returns Best Price
     *
     * @var array $frontendUserGroupIds
     *
     * @return float
     */
    public function getBestPrice($frontendUserGroupIds = [])
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

    /**
     * Returns best Special Price Discount
     *
     * @var array $frontendUserGroupIds
     * @return float
     */
    public function getBestSpecialPriceDiscount($frontendUserGroupIds = [])
    {
        $bestSpecialPrice = $this->getBestPriceCalculated($frontendUserGroupIds);
        $bestSpecialPriceDiscount = $this->getPriceCalculated() - $bestSpecialPrice;

        return $bestSpecialPriceDiscount;
    }

    /**
     * Returns best Special Price Percentage Discount
     *
     * @var array $frontendUserGroupIds
     * @return float
     */
    public function getBestSpecialPricePercentageDiscount($frontendUserGroupIds = [])
    {
        if ($this->getPriceCalculated() !== 0 && $this->getPriceCalculated() !== 0.0) {
            $bestSpecialPricePercentageDiscount = (($this->getBestSpecialPriceDiscount($frontendUserGroupIds)) / $this->getPriceCalculated()) * 100;
        }

        return $bestSpecialPricePercentageDiscount;
    }

    /**
     * Returns the Base Price
     *
     * @return float $price
     */
    public function getBasePrice()
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

    /**
     * Returns the Price Measure
     *
     * @return float $priceMeasure
     */
    public function getPriceMeasure()
    {
        return $this->priceMeasure;
    }

    /**
     * Sets the Price Measure
     *
     * @param float $priceMeasure
     */
    public function setPriceMeasure($priceMeasure)
    {
        $this->priceMeasure = $priceMeasure;
    }

    /**
     * Returns the Price Measure Unit
     *
     * @return string $priceMeasureUnit
     */
    public function getPriceMeasureUnit()
    {
        return $this->priceMeasureUnit;
    }

    /**
     * Sets the Price Measure Unit
     *
     * @param string $priceMeasureUnit
     */
    public function setPriceMeasureUnit($priceMeasureUnit)
    {
        $this->priceMeasureUnit = $priceMeasureUnit;
    }

    /**
     * Check Measure Unit Compatibility
     *
     * @return bool
     */
    public function getIsMeasureUnitCompatibility()
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

    /**
     * Get Measure Unit Faktor
     *
     * @return bool
     */
    public function getMeasureUnitFactor()
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
     * Returns Calculated Base Price
     *
     * @return float|bool
     */
    public function getCalculatedBasePrice()
    {
        if ($this->getIsMeasureUnitCompatibility()) {
            return $this->getBestPriceCalculated() * $this->getMeasureUnitFactor();
        }

        return false;
    }

    /**
     * Returns the Stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the Stock
     *
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Add To Stock
     *
     * @param int $stock
     */
    public function addToStock($stock)
    {
        $this->stock += $stock;
    }

    /**
     * Remove From Stock
     *
     * @param int $stock
     */
    public function removeFromStock($stock)
    {
        $this->stock -= $stock;
    }

    /**
     * Returns Is Available
     *
     * @return bool
     */
    public function getIsAvailable()
    {
        return boolval($this->stock);
    }

    /**
     * Returns the calculated SKU
     *
     * @return string
     */
    public function getSku()
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

    /**
     * Returns the calculated Title
     *
     * @return string
     */
    public function getTitle()
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
