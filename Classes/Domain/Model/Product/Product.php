<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

class Product extends \Extcode\CartProducts\Domain\Model\Product\AbstractProduct
{

    /**
     * Measurement Units
     *
     * @var array
     */
    protected $measureUnits = [
        'weight' => [
            'mg' => 1000,
            'g' => 1,
            'kg' => 0.001,
        ],
        'volume' => [
            'ml' => 1000,
            'cl' => 100,
            'l' => 1,
            'cbm' => 0.001,
        ],
        'length' => [
            'mm' => 1000,
            'cm' => 100,
            'm' => 1,
            'km' => 0.001,
        ],
        'area' => [
            'm2' => 1,
        ]
    ];

    /**
     * Product Type
     *
     * @var string
     */
    protected $productType = 'simple';

    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $images;

    /**
     * Files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files;

    /**
     * Teaser
     *
     * @var string
     */
    protected $teaser = '';

    /**
     * Product Content
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\TtContent>
     */
    protected $productContent;

    /**
     * Min Number In Order
     *
     * @var int
     */
    protected $minNumberInOrder = 0;

    /**
     * Max Number in Order
     *
     * @var int
     */
    protected $maxNumberInOrder = 0;

    /**
     * Is Net Price
     *
     * @var bool
     */
    protected $isNetPrice = false;

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
    protected $specialPrices;

    /**
     * Product Quantity Discount
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\QuantityDiscount>
     */
    protected $quantityDiscounts;

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
     * Base Price Measure Unit
     *
     * @var string
     */
    protected $basePriceMeasureUnit = '';

    /**
     * Service Attriute 1
     *
     * @var float
     */
    protected $serviceAttribute1 = 0.0;

    /**
     * Service Attriute 2
     *
     * @var float
     */
    protected $serviceAttribute2 = 0.0;

    /**
     * Service Attriute 3
     *
     * @var float
     */
    protected $serviceAttribute3 = 0.0;

    /**
     * Tax Class Id
     *
     * @var int
     */
    protected $taxClassId = 1;

    /**
     * beVariantAttribute1
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    protected $beVariantAttribute1 = null;

    /**
     * beVariantAttribute2
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    protected $beVariantAttribute2 = null;

    /**
     * beVariantAttribute3
     *
     * @var \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    protected $beVariantAttribute3 = null;

    /**
     * variants
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariant>
     */
    protected $beVariants = null;

    /**
     * Frontend Variants
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\FeVariant>
     */
    protected $feVariants = null;

    /**
     * Related Products
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product>
     */
    protected $relatedProducts = null;

    /**
     * Related Products (from)
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product>
     */
    protected $relatedProductsFrom;

    /**
     * stock
     *
     * @var int
     */
    protected $stock = 0;

    /**
     * Handle Stock
     *
     * @var bool
     */
    protected $handleStock = false;

    /**
     * Handle Stock in Variants
     *
     * @var bool
     */
    protected $handleStockInVariants = false;

    /**
     * Category
     *
     * @var \Extcode\CartProducts\Domain\Model\Category
     */
    protected $category;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Category>
     */
    protected $categories;

    /**
     * Tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\Tag>
     */
    protected $tags;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->specialPrices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->beVariants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the Product Type
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set the Product Type
     *
     * @var string $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * Returns the Images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Returns the first Image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getFirstImage()
    {
        return array_shift($this->getImages()->toArray());
    }

    /**
     * Sets the Images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * Returns the Files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the Files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Returns the teaser
     *
     * @return string $teaser
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Sets the teaser
     *
     * @param string $teaser
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * Returns the Product Content
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getProductContent()
    {
        return $this->productContent;
    }

    /**
     * Sets the Product Content
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $productContent
     */
    public function setProductContent($productContent)
    {
        $this->productContent = $productContent;
    }

    /**
     * @return int
     */
    public function getMinNumberInOrder()
    {
        return $this->minNumberInOrder;
    }

    /**
     * @param int $minNumberInOrder
     */
    public function setMinNumberInOrder($minNumberInOrder)
    {
        if ($minNumberInOrder < 0 || $minNumberInOrder > $this->maxNumberInOrder) {
            throw new \InvalidArgumentException;
        }

        $this->minNumberInOrder = $minNumberInOrder;
    }

    /**
     * @return int
     */
    public function getMaxNumberInOrder()
    {
        return $this->maxNumberInOrder;
    }

    /**
     * @param int $maxNumberInOrder
     */
    public function setMaxNumberInOrder($maxNumberInOrder)
    {
        if ($maxNumberInOrder < 0 || (($maxNumberInOrder !== 0) && ($maxNumberInOrder < $this->minNumberInOrder))) {
            throw new \InvalidArgumentException;
        }

        $this->maxNumberInOrder = $maxNumberInOrder;
    }

    /**
     * Returns the isNetPrice
     *
     * @return bool
     */
    public function getIsNetPrice()
    {
        return $this->isNetPrice;
    }

    /**
     * Sets the isNetPrice
     *
     * @param bool $isNetPrice
     */
    public function setIsNetPrice($isNetPrice)
    {
        $this->isNetPrice = $isNetPrice;
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
     * Returns the Special Prices
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\SpecialPrice>
     */
    public function getSpecialPrices()
    {
        return $this->specialPrices;
    }

    /**
     * Adds a Special Price
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\SpecialPrice $specialPrice
     */
    public function addSpecialPrice(\Extcode\CartProducts\Domain\Model\Product\SpecialPrice $specialPrice)
    {
        $this->specialPrices->attach($specialPrice);
    }

    /**
     * Removes a Special Price
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\SpecialPrice $specialPriceToRemove
     */
    public function removeSpecialPrice(\Extcode\CartProducts\Domain\Model\Product\SpecialPrice $specialPriceToRemove)
    {
        $this->specialPrices->detach($specialPriceToRemove);
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
     * Returns best Special Price
     *
     * @var array $frontendUserGroupIds
     * @return float
     */
    public function getBestSpecialPrice($frontendUserGroupIds = [])
    {
        $bestSpecialPrice = $this->price;

        if ($this->specialPrices) {
            foreach ($this->specialPrices as $specialPrice) {
                if ($specialPrice->getPrice() < $bestSpecialPrice) {
                    if (!$specialPrice->getFrontendUserGroup() ||
                        in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                    ) {
                        $bestSpecialPrice = $specialPrice->getPrice();
                    }
                }
            }
        }

        return $bestSpecialPrice;
    }

    /**
     * Returns best Special Price Discount
     *
     * @var array $frontendUserGroupIds
     * @return float
     */
    public function getBestSpecialPriceDiscount($frontendUserGroupIds = [])
    {
        $bestSpecialPrice = $this->getBestSpecialPrice($frontendUserGroupIds);
        $bestSpecialPriceDiscount = $this->price - $bestSpecialPrice;

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
        $bestSpecialPricePercentageDiscount = 0.0;

        if ($this->price > 0.0) {
            $bestSpecialPricePercentageDiscount = (($this->getBestSpecialPriceDiscount($frontendUserGroupIds)) / $this->price) * 100;
        }

        return $bestSpecialPricePercentageDiscount;
    }

    /**
     * Returns the Quantity Discounts
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\QuantityDiscount>
     */
    public function getQuantityDiscounts()
    {
        return $this->quantityDiscounts;
    }

    /**
     * Returns the Quantity Discounts as Array
     *
     * @return array
     */
    public function getQuantityDiscountArray($frontendUserGroupIds = [])
    {
        $quantityDiscountArray = [];

        if ($this->getQuantityDiscounts()) {
            foreach ($this->getQuantityDiscounts() as $quantityDiscount) {
                if (!$quantityDiscount->getFrontendUserGroup() ||
                    in_array($quantityDiscount->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                ) {
                    array_push($quantityDiscountArray, $quantityDiscount->toArray());
                }
            }
        }

        return $quantityDiscountArray;
    }

    /**
     * Adds a Quantity Discount
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\QuantityDiscount $quantityDiscount
     */
    public function addQuantityDiscount(\Extcode\CartProducts\Domain\Model\Product\QuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts->attach($quantityDiscount);
    }

    /**
     * Removes a Quantity Discount
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\QuantityDiscount $quantityDiscount
     */
    public function removeQuantityDiscount(\Extcode\CartProducts\Domain\Model\Product\QuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts->detach($quantityDiscount);
    }

    /**
     * Sets the Quantity Discounts
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $quantityDiscounts
     */
    public function setQuantityDiscounts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $quantityDiscounts)
    {
        $this->quantityDiscounts = $quantityDiscounts;
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
     * Returns the Base Price Measure Unit
     *
     * @return string $basePriceMeasureUnit
     */
    public function getBasePriceMeasureUnit()
    {
        return $this->basePriceMeasureUnit;
    }

    /**
     * Sets the Basse Price Measure Unit
     *
     * @param string $basePriceMeasureUnit
     */
    public function setBasePriceMeasureUnit($basePriceMeasureUnit)
    {
        $this->basePriceMeasureUnit = $basePriceMeasureUnit;
    }

    /**
     * Check Measure Unit Compatibility
     *
     * @return bool
     */
    public function getIsMeasureUnitCompatibility()
    {
        foreach ($this->measureUnits as $measureUnit) {
            if (array_key_exists($this->basePriceMeasureUnit, $measureUnit)
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
     * @return float
     */
    public function getMeasureUnitFactor()
    {
        $factor = 1.0;

        foreach ($this->measureUnits as $measureUnit) {
            if (array_key_exists($this->priceMeasureUnit, $measureUnit)) {
                $factor = $factor / ($this->priceMeasure / $measureUnit[$this->priceMeasureUnit]);
            }
            if (array_key_exists($this->basePriceMeasureUnit, $measureUnit)) {
                $factor = $factor * (1.0 / $measureUnit[$this->basePriceMeasureUnit]);
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
            return $this->getMinPrice() * $this->getMeasureUnitFactor();
        }

        return false;
    }

    /**
     * Returns Service Attribute 1
     *
     * @return float
     */
    public function getServiceAttribute1()
    {
        return $this->serviceAttribute1;
    }

    /**
     * Sets Service Attribute 1
     *
     * @param float $serviceAttribute1
     */
    public function setServiceAttribute1($serviceAttribute1)
    {
        $this->serviceAttribute1 = $serviceAttribute1;
    }

    /**
     * Returns Service Attribute 2
     *
     * @return float
     */
    public function getServiceAttribute2()
    {
        return $this->serviceAttribute2;
    }

    /**
     * Sets Service Attribute 2
     *
     * @param float $serviceAttribute2
     */
    public function setServiceAttribute2($serviceAttribute2)
    {
        $this->serviceAttribute2 = $serviceAttribute2;
    }

    /**
     * Returns Service Attribute 3
     *
     * @return float
     */
    public function getServiceAttribute3()
    {
        return $this->serviceAttribute3;
    }

    /**
     * Sets Service Attribute 3
     *
     * @param float $serviceAttribute3
     */
    public function setServiceAttribute3($serviceAttribute3)
    {
        $this->serviceAttribute3 = $serviceAttribute3;
    }

    /**
     * Returns Tax Class Id
     *
     * @return int
     */
    public function getTaxClassId()
    {
        return $this->taxClassId;
    }

    /**
     * Sets Tax Class Id
     *
     * @param int $taxClassId
     */
    public function setTaxClassId($taxClassId)
    {
        $this->taxClassId = $taxClassId;
    }

    /**
     * Returns the Variant Set 1
     *
     * @return \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    public function getBeVariantAttribute1()
    {
        return $this->beVariantAttribute1;
    }

    /**
     * Sets the Variant Set 1
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute1
     */
    public function setBeVariantAttribute1(\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute1)
    {
        $this->beVariantAttribute1 = $beVariantAttribute1;
    }

    /**
     * Returns the Variant Set 2
     *
     * @return \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    public function getBeVariantAttribute2()
    {
        return $this->beVariantAttribute2;
    }

    /**
     * Sets the Variant Set 2
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute2
     */
    public function setBeVariantAttribute2(\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute2)
    {
        $this->beVariantAttribute2 = $beVariantAttribute2;
    }

    /**
     * Returns the Variant Set 3
     *
     * @return \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute
     */
    public function getBeVariantAttribute3()
    {
        return $this->beVariantAttribute3;
    }

    /**
     * Sets the Variant Set 3
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute3
     */
    public function setBeVariantAttribute3(\Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute $beVariantAttribute3)
    {
        $this->beVariantAttribute3 = $beVariantAttribute3;
    }

    /**
     * Adds a Variant
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariant $variant
     */
    public function addBeVariant(\Extcode\CartProducts\Domain\Model\Product\BeVariant $variant)
    {
        $this->beVariants->attach($variant);
    }

    /**
     * Removes a Variant
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\BeVariant $variantToRemove
     */
    public function removeBeVariant(\Extcode\CartProducts\Domain\Model\Product\BeVariant $variantToRemove)
    {
        $this->beVariants->detach($variantToRemove);
    }

    /**
     * Returns the Variants
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariant> $variant
     */
    public function getBeVariants()
    {
        return $this->beVariants;
    }

    /**
     * Sets the Variants
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $variants
     */
    public function setBeVariants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $variants)
    {
        $this->beVariants = $variants;
    }

    /**
     * Adds a Frontend Variant
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\FeVariant $feVariant
     */
    public function addFeVariant(\Extcode\CartProducts\Domain\Model\Product\FeVariant $feVariant)
    {
        $this->feVariants->attach($feVariant);
    }

    /**
     * Removes a Frontend Variant
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\FeVariant $feVariantToRemove
     */
    public function removeFeVariant(\Extcode\CartProducts\Domain\Model\Product\FeVariant $feVariantToRemove)
    {
        $this->feVariants->detach($feVariantToRemove);
    }

    /**
     * Returns the Frontend Variants
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\FeVariant> $variant
     */
    public function getFeVariants()
    {
        return $this->feVariants;
    }

    /**
     * Sets the Frontend Variants
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $feVariants
     */
    public function setFeVariants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $feVariants)
    {
        $this->feVariants = $feVariants;
    }

    /**
     * Adds a Related Product
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $relatedProduct
     */
    public function addRelatedProduct(self $relatedProduct)
    {
        $this->relatedProducts->attach($relatedProduct);
    }

    /**
     * Removes a Related Product
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $relatedProductToRemove
     */
    public function removeRelatedProduct(self $relatedProductToRemove)
    {
        $this->relatedProducts->detach($relatedProductToRemove);
    }

    /**
     * Returns the Related Products
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product> $relatedProduct
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    /**
     * Sets the Related Products
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product> $relatedProducts
     */
    public function setRelatedProducts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    /**
     * Adds a Related Product (from)
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $relatedProductFrom
     */
    public function addRelatedProductFrom(self $relatedProductFrom)
    {
        $this->relatedProductsFrom->attach($relatedProductFrom);
    }

    /**
     * Removes a Related Product (from)
     *
     * @param \Extcode\CartProducts\Domain\Model\Product\Product $relatedProductFromToRemove
     */
    public function removeRelatedProductFrom(self $relatedProductFromToRemove)
    {
        $this->relatedProductsFrom->detach($relatedProductFromToRemove);
    }

    /**
     * Returns the Related Products (from)
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product> $relatedProductFrom
     */
    public function getRelatedProductsFrom()
    {
        return $this->relatedProductsFrom;
    }

    /**
     * Sets the Related Products (from)
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\Product> $relatedProductsFrom
     */
    public function setRelatedProductsFrom(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relatedProductsFrom)
    {
        $this->relatedProductsFrom = $relatedProductsFrom;
    }

    /**
     * Returns the Stock
     *
     * @return int
     */
    public function getStock()
    {
        if (!$this->handleStock) {
            return PHP_INT_MAX;
        }

        if ($this->handleStockInVariants) {
            $count = 0;
            if (count($this->beVariants)) {
                foreach ($this->beVariants as $variant) {
                    $count += $variant->getStock();
                }
            }
            return $count;
        }

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
     * @param int $numberOfProducts
     */
    public function addToStock($numberOfProducts)
    {
        if ($this->isHandleStock()) {
            $this->stock += $numberOfProducts;
        }
    }

    /**
     * Remove From Stock
     *
     * @param int $numberOfProducts
     */
    public function removeFromStock($numberOfProducts)
    {
        if ($this->isHandleStock()) {
            $this->stock -= $numberOfProducts;
        }
    }

    /**
     * Returns Handle Stock
     *
     * @return bool
     */
    public function isHandleStock()
    {
        return $this->handleStock;
    }

    /**
     * Sets Handle Stock
     *
     * @param bool $handleStock
     */
    public function setHandleStock($handleStock)
    {
        $this->handleStock = $handleStock;
    }

    /**
     * Returns Handle Stock In Variants
     *
     * @return bool
     */
    public function isHandleStockInVariants()
    {
        return $this->handleStockInVariants;
    }

    /**
     * Sets Handle Stock In Variants
     *
     * @param bool $handleStockInVariants
     */
    public function setHandleStockInVariants($handleStockInVariants)
    {
        $this->handleStockInVariants = $handleStockInVariants;
    }

    /**
     * Returns Is Available
     *
     * @return bool
     */
    public function getIsAvailable()
    {
        if (!$this->handleStock) {
            return true;
        } else {
            if (!$this->handleStockInVariants) {
                return boolval($this->stock);
            } else {
                if (count($this->beVariants)) {
                    foreach ($this->beVariants as $beVariant) {
                        if ($beVariant->getIsAvailable()) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns the Main Category
     *
     * @return \Extcode\CartProducts\Domain\Model\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the Main Category
     *
     * @param \Extcode\CartProducts\Domain\Model\Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Adds a Product Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the Categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Returns the First Category
     *
     * @return \Extcode\CartProducts\Domain\Model\Category
     */
    public function getFirstCategory()
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        } else {
            return null;
        }
    }

    /**
     * Sets the Categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * get the minimal Price from Variants
     *
     * @return float
     */
    public function getMinPrice()
    {
        $minPrice = null;
        if (count($this->getBeVariants())) {
            foreach ($this->getBeVariants() as $variant) {
                if (!isset($minPrice)) {
                    $minPrice = $variant->getBestPriceCalculated();
                } else {
                    if ($variant->getBestPriceCalculated() < $minPrice) {
                        $minPrice = $variant->getBestPriceCalculated();
                    }
                }
            }
        } else {
            $minPrice = $this->getPrice();
        }

        return $minPrice;
    }

    /**
     * Returns MeasureUnits
     *
     * @return array
     */
    public function getMeasureUnits()
    {
        return $this->measureUnits;
    }

    /**
     * Sets MeasureUnits
     *
     * @param array $measureUnits
     */
    public function setMeasureUnits($measureUnits)
    {
        $this->measureUnits = $measureUnits;
    }

    /**
     * Adds a Tag
     *
     * @param \Extcode\Cart\Domain\Model\Tag $tag
     */
    public function addTag(\Extcode\Cart\Domain\Model\Tag $tag)
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param \Extcode\Cart\Domain\Model\Tag $tagToRemove
     */
    public function removeTag(\Extcode\Cart\Domain\Model\Tag $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the Tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\Tag>
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets the Tags
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\Cart\Domain\Model\Tag> $tags
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }
}
