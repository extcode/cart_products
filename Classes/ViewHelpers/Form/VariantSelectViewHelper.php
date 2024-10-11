<?php

namespace Extcode\CartProducts\ViewHelpers\Form;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\ViewHelpers\Format\CurrencyViewHelper;
use Extcode\CartProducts\Domain\Model\Product\BeVariant;
use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class VariantSelectViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var Product
     */
    protected $product;

    public function __construct(
        private readonly Context $context,
    ) {}

    /**
     * Initialize arguments.
     *
     * @api
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument(
            'product',
            Product::class,
            'product for select options',
            true
        );
        $this->registerArgument('id', 'string', 'id for select');
        $this->registerArgument('class', 'string', 'class for select');
        $this->registerArgument('name', 'string', 'name for select');
        $this->registerArgument('blank', 'string', 'blank adds blank option');
        $this->registerArgument('required', 'bool', 'required adds html5 required', false, true);
    }

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        $this->product = $this->arguments['product'];

        $select = [];

        if ($this->hasArgument('id')) {
            $select[] = 'id="' . $this->arguments['id'] . '" ';
        }
        if ($this->hasArgument('class')) {
            $select[] = 'class="' . $this->arguments['class'] . '" ';
        }
        if ($this->hasArgument('name')) {
            $select[] = 'name="' . $this->arguments['name'] . '" ';
        }
        if ($this->hasArgument('required')) {
            $select[] = 'required ';
        }

        if ($this->product->getBeVariantAttribute1()) {
            $select[] = 'data-be-variant-title-1="' . $this->product->getBeVariantAttribute1()->getTitle() . '"';
            $select[] = 'data-be-variant-sku-1="' . $this->product->getBeVariantAttribute1()->getSku() . '"';
        }
        if ($this->product->getBeVariantAttribute2()) {
            $select[] = 'data-be-variant-title-2="' . $this->product->getBeVariantAttribute2()->getTitle() . '"';
            $select[] = 'data-be-variant-sku-2="' . $this->product->getBeVariantAttribute2()->getSku() . '"';
        }
        if ($this->product->getBeVariantAttribute3()) {
            $select[] = 'data-be-variant-title-3="' . $this->product->getBeVariantAttribute3()->getTitle() . '"';
            $select[] = 'data-be-variant-sku-3="' . $this->product->getBeVariantAttribute3()->getSku() . '"';
        }

        $out = '<select ' . implode(' ', $select) . '>';

        if ($this->hasArgument('blank')) {
            $out .= '<option value="">' . $this->arguments['blank'] . '</option>';
        }

        $options = $this->getOptions();

        foreach ($options as $option) {
            $out .= $option;
        }

        return $out .= '</select>';
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        $options = [];

        $currencyViewHelper = GeneralUtility::makeInstance(
            CurrencyViewHelper::class
        );
        $currencyViewHelper->initialize();
        $currencyViewHelper->setRenderingContext($this->renderingContext);

        foreach ($this->product->getBeVariants() as $beVariant) {
            /**
             * @var BeVariant $beVariant
             */
            $currencyViewHelper->setRenderChildrenClosure(
                fn() => $beVariant->getPriceCalculated()
            );
            $regularPrice = $currencyViewHelper->render();

            $frontendUserGroupIds = $this->context->getPropertyFromAspect('frontend.user', 'groupIds');

            $currencyViewHelper->setRenderChildrenClosure(
                fn() => $beVariant->getBestPriceCalculated($frontendUserGroupIds)
            );

            $specialPrice = $currencyViewHelper->render();

            $specialPricePercentageDiscount = number_format($beVariant->getBestSpecialPricePercentageDiscount(), 2);

            $optionLabel = $this->getOptionLabel($beVariant);

            $value = 'value="' . $beVariant->getUid() . '"';
            $data = '';

            $data .= ' data-be-variant-uid="' . $beVariant->getUid() . '"';

            if ($this->product->getBeVariantAttribute1()) {
                $data .= ' data-be-variant-title-1="' . $beVariant->getBeVariantAttributeOption1()->getTitle() . '"';
                $data .= ' data-be-variant-sku-1="' . $beVariant->getBeVariantAttributeOption1()->getSku() . '"';
            }
            if ($this->product->getBeVariantAttribute2()) {
                $data .= ' data-be-variant-title-2="' . $beVariant->getBeVariantAttributeOption2()->getTitle() . '"';
                $data .= ' data-be-variant-sku-2="' . $beVariant->getBeVariantAttributeOption2()->getSku() . '"';
            }
            if ($this->product->getBeVariantAttribute3()) {
                $data .= ' data-be-variant-title-3="' . $beVariant->getBeVariantAttributeOption3()->getTitle() . '"';
                $data .= ' data-be-variant-sku-3="' . $beVariant->getBeVariantAttributeOption3()->getSku() . '"';
            }

            $data .= 'data-regular-price="' . $regularPrice . '"';
            if ($regularPrice !== $specialPrice) {
                $data .= ' data-special-price="' . $specialPrice . '"';
                $data .= ' data-special-price-percentage-discount="' . $specialPricePercentageDiscount . '"';
            }
            $disabled = '';
            if (!$beVariant->getIsAvailable() && $beVariant->getProduct()->isHandleStockInVariants()) {
                $disabled = 'disabled';
            }

            $option = '<option ' . $value . ' ' . $data . ' ' . $disabled . '>' . $optionLabel . '</option>';
            $options[$optionLabel] = $option;
        }

        return $options;
    }

    /**
     * @param BeVariant $beVariant
     *
     * @return string
     */
    protected function getOptionLabel(BeVariant $beVariant): string
    {
        $optionLabelArray = [];

        if ($this->product->getBeVariantAttribute1()) {
            $optionLabelArray[] = $beVariant->getBeVariantAttributeOption1()->getTitle();
        }
        if ($this->product->getBeVariantAttribute2()) {
            $optionLabelArray[] = $beVariant->getBeVariantAttributeOption2()->getTitle();
        }
        if ($this->product->getBeVariantAttribute3()) {
            $optionLabelArray[] = $beVariant->getBeVariantAttributeOption3()->getTitle();
        }

        return implode(' - ', $optionLabelArray);
    }
}
