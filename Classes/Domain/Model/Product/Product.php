<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\Cart\Domain\Model\Product\AbstractProduct;
use Extcode\Cart\Domain\Model\Product\CategoryTrait;
use Extcode\Cart\Domain\Model\Product\FileAndImageTrait;
use Extcode\Cart\Domain\Model\Product\MeasureTrait;
use Extcode\Cart\Domain\Model\Product\ServiceAttributeTrait;
use Extcode\Cart\Domain\Model\Product\TagTrait;
use Extcode\CartProducts\Domain\Model\Category;
use Extcode\CartProducts\Domain\Model\TtContent;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Product extends AbstractProduct
{
    use CategoryTrait;
    use FileAndImageTrait;
    use ProductBackendVariantTrait;
    use MeasureTrait;
    use ServiceAttributeTrait;
    use TagTrait;

    protected string $productType = 'simple';

    /**
     * @var ObjectStorage<TtContent>
     */
    #[Lazy]
    protected ?ObjectStorage $productContent = null;

    protected int $minNumberInOrder = 0;

    protected int $maxNumberInOrder = 0;

    protected bool $isNetPrice = false;

    protected float $price = 0.0;
    
    protected $feGroup = '';

    /**
     * @var ObjectStorage<SpecialPrice>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $specialPrices;

    /**
     * @var ObjectStorage<QuantityDiscount>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $quantityDiscounts;

    protected int $taxClassId = 1;

    /**
     * @var ObjectStorage<FeVariant>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $feVariants;

    /**
     * @var ObjectStorage<Product>
     */
    #[Lazy]
    protected ?ObjectStorage $relatedProducts = null;

    /**
     * @var ObjectStorage<Product>
     */
    #[Lazy]
    protected ?ObjectStorage $relatedProductsFrom = null;

    protected int $stock = 0;

    protected bool $handleStock = false;

    protected bool $handleStockInVariants = false;

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
            throw new \InvalidArgumentException();
        }

        $this->minNumberInOrder = $minNumberInOrder;
    }

    public function getMaxNumberInOrder(): int
    {
        return $this->maxNumberInOrder;
    }

    public function setMaxNumberInOrder(int $maxNumberInOrder): void
    {
        if ($maxNumberInOrder < 0 || (($maxNumberInOrder !== 0) && ($maxNumberInOrder < $this->minNumberInOrder))) {
            throw new \InvalidArgumentException();
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

        foreach ($this->specialPrices as $specialPrice) {
            if ($specialPrice->getPrice() < $bestSpecialPrice) {
                if (
                    !$specialPrice->getFrontendUserGroup()
                    || in_array($specialPrice->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
                ) {
                    $bestSpecialPrice = $specialPrice->getPrice();
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
                if (!$quantityDiscount->getFrontendUserGroup()
                    || in_array($quantityDiscount->getFrontendUserGroup()->getUid(), $frontendUserGroupIds)
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

    public function getCalculatedBasePrice(): float
    {
        if ($this->getIsMeasureUnitCompatibility()) {
            return $this->getMinPrice() * $this->getMeasureUnitFactor();
        }

        return 0.0;
    }

    public function getTaxClassId(): int
    {
        return $this->taxClassId;
    }

    public function setTaxClassId(int $taxClassId): void
    {
        $this->taxClassId = $taxClassId;
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
                foreach ($this->beVariants as $beVariant) {
                    $count += $beVariant->getStock();
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
            return (bool)($this->stock);
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

    public function getFirstCategory(): ?Category
    {
        $categories = $this->getCategories();
        $categories->rewind();
        return $categories->current();
    }

    public function getMinPrice(): float
    {
        $minPrice = null;
        if (count($this->beVariants)) {
            foreach ($this->beVariants as $beVariant) {
                if (!isset($minPrice)) {
                    $minPrice = $beVariant->getBestPriceCalculated();
                } else {
                    if ($beVariant->getBestPriceCalculated() < $minPrice) {
                        $minPrice = $beVariant->getBestPriceCalculated();
                    }
                }
            }
        } else {
            $minPrice = $this->getPrice();
        }

        return $minPrice;
    }

    public function getFeGroup(): string
    {
        return $this->feGroup;
    }

    public function setFeGroup($feGroup): void
    {
        $this->feGroup = $feGroup;
    }
}
