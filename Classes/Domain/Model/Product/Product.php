<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Tag;
use Extcode\CartProducts\Domain\Model\Category;
use Extcode\CartProducts\Domain\Model\TtContent;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Product extends AbstractProduct
{

    /**
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
     * @var string
     */
    protected $productType = 'simple';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $images;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $files;

    /**
     * @var string
     */
    protected $teaser = '';

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var ObjectStorage<\Extcode\CartProducts\Domain\Model\TtContent>
     */
    protected $productContent;

    /**
     * @var int
     */
    protected $minNumberInOrder = 0;

    /**
     * @var int
     */
    protected $maxNumberInOrder = 0;

    /**
     * @var bool
     */
    protected $isNetPrice = false;

    /**
     * @var float
     */
    protected $price = 0.0;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var ObjectStorage<SpecialPrice>
     */
    protected $specialPrices;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var ObjectStorage<QuantityDiscount>
     */
    protected $quantityDiscounts;

    /**
     * @var float
     */
    protected $priceMeasure = 0.0;

    /**
     * @var string
     */
    protected $priceMeasureUnit = '';

    /**
     * @var string
     */
    protected $basePriceMeasureUnit = '';

    /**
     * @var float
     */
    protected $serviceAttribute1 = 0.0;

    /**
     * @var float
     */
    protected $serviceAttribute2 = 0.0;

    /**
     * @var float
     */
    protected $serviceAttribute3 = 0.0;

    /**
     * @var int
     */
    protected $taxClassId = 1;

    /**
     * @var BeVariantAttribute
     */
    protected $beVariantAttribute1;

    /**
     * @var BeVariantAttribute
     */
    protected $beVariantAttribute2;

    /**
     * @var BeVariantAttribute
     */
    protected $beVariantAttribute3;

    /**
     * variants
     *
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var ObjectStorage<BeVariant>
     */
    protected $beVariants;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @var ObjectStorage<FeVariant>
     */
    protected $feVariants;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var ObjectStorage<Product>
     */
    protected $relatedProducts;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var ObjectStorage<Product>
     */
    protected $relatedProductsFrom;

    /**
     * @var int
     */
    protected $stock = 0;

    /**
     * @var bool
     */
    protected $handleStock = false;

    /**
     * @var bool
     */
    protected $handleStockInVariants = false;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var ObjectStorage<Category>
     */
    protected $categories;

    /**
     * @var ObjectStorage<Tag>
     */
    protected $tags;

    public function __construct()
    {
        $this->specialPrices = new ObjectStorage();
        $this->beVariants = new ObjectStorage();
        $this->feVariants = new ObjectStorage();
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): void
    {
        $this->productType = $productType;
    }

    public function getImages(): ?ObjectStorage
    {
        return $this->images;
    }

    public function getFirstImage(): ?FileReference
    {
        $images = $this->getImages();
        if ($images) {
            $imageArray = $images->toArray();
            return array_shift($imageArray);
        }

        return null;
    }

    /**
     * @param ObjectStorage<FileReference> $images
     */
    public function setImages(ObjectStorage $images)
    {
        $this->images = $images;
    }

    public function getFiles(): ?ObjectStorage
    {
        return $this->files;
    }

    /**
     * @param ObjectStorage<FileReference> $files
     */
    public function setFiles(ObjectStorage $files): void
    {
        $this->files = $files;
    }

    public function getTeaser(): string
    {
        return $this->teaser;
    }

    public function setTeaser(string $teaser): void
    {
        $this->teaser = $teaser;
    }

    public function getProductContent(): ?ObjectStorage
    {
        return $this->productContent;
    }

    /**
     * @param ObjectStorage<TtContent> $productContent
     */
    public function setProductContent(ObjectStorage $productContent): void
    {
        $this->productContent = $productContent;
    }

    public function getMinNumberInOrder(): int
    {
        return $this->minNumberInOrder;
    }

    public function setMinNumberInOrder(int $minNumberInOrder): void
    {
        if ($minNumberInOrder < 0 || $minNumberInOrder > $this->maxNumberInOrder) {
            throw new \InvalidArgumentException;
        }

        $this->minNumberInOrder = $minNumberInOrder;
    }

    public function getMaxNumberInOrder(): int
    {
        return $this->maxNumberInOrder;
    }

    public function setMaxNumberInOrder(int $maxNumberInOrder)
    {
        if ($maxNumberInOrder < 0 || (($maxNumberInOrder !== 0) && ($maxNumberInOrder < $this->minNumberInOrder))) {
            throw new \InvalidArgumentException;
        }

        $this->maxNumberInOrder = $maxNumberInOrder;
    }

    public function getIsNetPrice(): bool
    {
        return $this->isNetPrice;
    }

    public function setIsNetPrice(bool $isNetPrice): void
    {
        $this->isNetPrice = $isNetPrice;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return ObjectStorage<SpecialPrice>
     */
    public function getSpecialPrices(): ObjectStorage
    {
        return $this->specialPrices;
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
     * @param ObjectStorage<SpecialPrice> $specialPrices
     */
    public function setSpecialPrices(ObjectStorage $specialPrices): void
    {
        $this->specialPrices = $specialPrices;
    }

    public function getBestSpecialPrice(array $frontendUserGroupIds = []): float
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

    public function getBestSpecialPriceDiscount(array $frontendUserGroupIds = []): float
    {
        $bestSpecialPrice = $this->getBestSpecialPrice($frontendUserGroupIds);
        $bestSpecialPriceDiscount = $this->price - $bestSpecialPrice;

        return $bestSpecialPriceDiscount;
    }

    public function getBestSpecialPricePercentageDiscount(array $frontendUserGroupIds = []): float
    {
        $bestSpecialPricePercentageDiscount = 0.0;

        if ($this->price > 0.0) {
            $bestSpecialPricePercentageDiscount = (($this->getBestSpecialPriceDiscount($frontendUserGroupIds)) / $this->price) * 100;
        }

        return $bestSpecialPricePercentageDiscount;
    }

    /**
     * @return ObjectStorage<QuantityDiscount>
     */
    public function getQuantityDiscounts(): ?ObjectStorage
    {
        return $this->quantityDiscounts;
    }

    public function getQuantityDiscountArray(array $frontendUserGroupIds = []): array
    {
        $quantityDiscountArray = [];

        if ($this->getQuantityDiscounts()) {
            foreach ($this->getQuantityDiscounts() as $quantityDiscount) {
                if (!$quantityDiscount->getFrontendUserGroup() ||
                    in_array($quantityDiscount->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                ) {
                    $quantityDiscountArray[] = $quantityDiscount->toArray();
                }
            }
        }

        return $quantityDiscountArray;
    }

    public function addQuantityDiscount(QuantityDiscount $quantityDiscount): void
    {
        $this->quantityDiscounts->attach($quantityDiscount);
    }

    public function removeQuantityDiscount(QuantityDiscount $quantityDiscount): void
    {
        $this->quantityDiscounts->detach($quantityDiscount);
    }

    /**
     * @param ObjectStorage<QuantityDiscount> $quantityDiscounts
     */
    public function setQuantityDiscounts(ObjectStorage $quantityDiscounts): void
    {
        $this->quantityDiscounts = $quantityDiscounts;
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

    public function getBasePriceMeasureUnit(): string
    {
        return $this->basePriceMeasureUnit;
    }

    public function setBasePriceMeasureUnit(string $basePriceMeasureUnit): void
    {
        $this->basePriceMeasureUnit = $basePriceMeasureUnit;
    }

    public function getIsMeasureUnitCompatibility(): bool
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

    public function getMeasureUnitFactor(): float
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
     * @return float|bool
     */
    public function getCalculatedBasePrice()
    {
        if ($this->getIsMeasureUnitCompatibility()) {
            return $this->getMinPrice() * $this->getMeasureUnitFactor();
        }

        return false;
    }

    public function getServiceAttribute1(): float
    {
        return $this->serviceAttribute1;
    }

    public function setServiceAttribute1(float $serviceAttribute1): void
    {
        $this->serviceAttribute1 = $serviceAttribute1;
    }

    public function getServiceAttribute2(): float
    {
        return $this->serviceAttribute2;
    }

    public function setServiceAttribute2(float $serviceAttribute2): void
    {
        $this->serviceAttribute2 = $serviceAttribute2;
    }

    public function getServiceAttribute3(): float
    {
        return $this->serviceAttribute3;
    }

    public function setServiceAttribute3(float $serviceAttribute3): void
    {
        $this->serviceAttribute3 = $serviceAttribute3;
    }

    public function getTaxClassId(): int
    {
        return $this->taxClassId;
    }

    public function setTaxClassId(int $taxClassId): void
    {
        $this->taxClassId = $taxClassId;
    }

    public function getBeVariantAttribute1(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute1;
    }

    public function setBeVariantAttribute1(BeVariantAttribute $beVariantAttribute1): void
    {
        $this->beVariantAttribute1 = $beVariantAttribute1;
    }

    public function getBeVariantAttribute2(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute2;
    }

    public function setBeVariantAttribute2(BeVariantAttribute $beVariantAttribute2): void
    {
        $this->beVariantAttribute2 = $beVariantAttribute2;
    }

    public function getBeVariantAttribute3(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute3;
    }

    public function setBeVariantAttribute3(BeVariantAttribute $beVariantAttribute3): void
    {
        $this->beVariantAttribute3 = $beVariantAttribute3;
    }

    public function addBeVariant(BeVariant $beVariant): void
    {
        $this->beVariants->attach($beVariant);
    }

    public function removeBeVariant(BeVariant $beVariant): void
    {
        $this->beVariants->detach($beVariant);
    }

    /**
     * @return ObjectStorage<BeVariant>
     */
    public function getBeVariants(): ObjectStorage
    {
        return $this->beVariants;
    }

    /**
     * @param ObjectStorage<BeVariant> $beVariants
     */
    public function setBeVariants(ObjectStorage $beVariants): void
    {
        $this->beVariants = $beVariants;
    }

    public function addFeVariant(FeVariant $feVariant): void
    {
        $this->feVariants->attach($feVariant);
    }

    public function removeFeVariant(FeVariant $feVariant): void
    {
        $this->feVariants->detach($feVariant);
    }

    /**
     * @return ObjectStorage<FeVariant>
     */
    public function getFeVariants(): ObjectStorage
    {
        return $this->feVariants;
    }

    /**
     * @param ObjectStorage<FeVariant> $feVariants
     */
    public function setFeVariants(ObjectStorage $feVariants): void
    {
        $this->feVariants = $feVariants;
    }

    public function addRelatedProduct(self $relatedProduct): void
    {
        $this->relatedProducts->attach($relatedProduct);
    }

    public function removeRelatedProduct(self $relatedProduct): void
    {
        $this->relatedProducts->detach($relatedProduct);
    }

    /**
     * @return ObjectStorage<Product>
     */
    public function getRelatedProducts(): ?ObjectStorage
    {
        return $this->relatedProducts;
    }

    /**
     * @param ObjectStorage<Product> $relatedProducts
     */
    public function setRelatedProducts(ObjectStorage $relatedProducts): void
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function addRelatedProductFrom(self $relatedProductFrom): void
    {
        $this->relatedProductsFrom->attach($relatedProductFrom);
    }

    public function removeRelatedProductFrom(self $relatedProductFrom): void
    {
        $this->relatedProductsFrom->detach($relatedProductFrom);
    }

    /**
     * @return ObjectStorage<Product>
     */
    public function getRelatedProductsFrom(): ?ObjectStorage
    {
        return $this->relatedProductsFrom;
    }

    /**
     * @param ObjectStorage<Product> $relatedProductsFrom
     */
    public function setRelatedProductsFrom(ObjectStorage $relatedProductsFrom): void
    {
        $this->relatedProductsFrom = $relatedProductsFrom;
    }

    public function getStock(): int
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

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function addToStock(int $numberOfProducts): void
    {
        if ($this->isHandleStock()) {
            $this->stock += $numberOfProducts;
        }
    }

    public function removeFromStock(int $numberOfProducts): void
    {
        if ($this->isHandleStock()) {
            $this->stock -= $numberOfProducts;
        }
    }

    public function isHandleStock(): bool
    {
        return $this->handleStock;
    }

    public function setHandleStock(bool $handleStock): void
    {
        $this->handleStock = $handleStock;
    }

    public function isHandleStockInVariants(): bool
    {
        return $this->handleStockInVariants;
    }

    public function setHandleStockInVariants(bool $handleStockInVariants): void
    {
        $this->handleStockInVariants = $handleStockInVariants;
    }

    public function getIsAvailable(): bool
    {
        if (!$this->handleStock) {
            return true;
        }
        if (!$this->handleStockInVariants) {
            return boolval($this->stock);
        }
        if (count($this->beVariants)) {
            foreach ($this->beVariants as $beVariant) {
                if ($beVariant->getIsAvailable()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    public function getFirstCategory(): ?Category
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        }

        return null;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function getMinPrice(): float
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

    public function getMeasureUnits(): array
    {
        return $this->measureUnits;
    }

    public function setMeasureUnits(array $measureUnits): void
    {
        $this->measureUnits = $measureUnits;
    }

    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    public function removeTag(Tag $tagToRemove): void
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * @return ObjectStorage<Tag>
     */
    public function getTags(): ?ObjectStorage
    {
        return $this->tags;
    }

    /**
     * @param  ObjectStorage<Tag> $tags
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }
}
