<?php

namespace Extcode\CartProducts\Utility;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\Cart\Domain\Model\Cart\TaxClass;
use Extcode\Cart\Domain\Model\Cart\BeVariant;
use Extcode\Cart\Domain\Model\Cart\Cart;
use Extcode\Cart\Domain\Model\Cart\FeVariant;
use Extcode\Cart\Domain\Model\Cart\Product;
use Extcode\CartProducts\Domain\Repository\Product\BeVariantRepository;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ProductUtility
{
    /**
     * Tax Classes
     *
     * @var array
     */
    protected $taxClasses;

    /**
     * Get Frontend User Group
     *
     * @return array
     */
    protected function getFrontendUserGroupIds()
    {
        $feGroupIds = [];
        $feUserId = (int)$GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserId) {
            $frontendUserRepository = GeneralUtility::makeInstance(
                FrontendUserRepository::class
            );
            $feUser = $frontendUserRepository->findByUid($feUserId);
            $feGroups = $feUser->getUsergroup();
            if ($feGroups) {
                foreach ($feGroups as $feGroup) {
                    $feGroupIds[] = $feGroup->getUid();
                }
            }
        }
        return $feGroupIds;
    }

    /**
     * Get Cart/Product From Request
     *
     * @param Request $request Request
     * @param TaxClass[] $taxClasses Tax Class Array
     *
     * @return Product
     */
    public function getProductFromRequest(Request $request, array $taxClasses)
    {
        if (!$this->taxClasses) {
            $this->taxClasses = $taxClasses;
        }

        $cartProductValues = $this->retrieveCartProductValuesFromRequest($request);

        return $this->createCartProduct($cartProductValues);
    }

    /**
     * @param array $taxClasses
     */
    public function setTaxClasses(array $taxClasses)
    {
        $this->taxClasses = $taxClasses;
    }

    /**
     * Create a CartProduct from array
     *
     * @param array $cartProductValues
     *
     * @return Product|null
     */
    protected function createCartProduct(array $cartProductValues)
    {
        $cartProduct = null;

        $productId = intval($cartProductValues['productId']);

        $productRepository = GeneralUtility::makeInstance(
            ProductRepository::class
        );

        /** @var \Extcode\CartProducts\Domain\Model\Product\Product $productProduct */
        $productProduct = $productRepository->findByUid($productId);

        if ($productProduct) {
            $frontendUserGroupIds = $this->getFrontendUserGroupIds();

            $feVariantValues = $cartProductValues['feVariants'];

            $feVariants = $productProduct->getFeVariants();

            if ($feVariants) {
                $cartProductValues['feVariants'] = [];
                foreach ($feVariants as $feVariant) {
                    if ($feVariantValues[$feVariant->getSku()]) {
                        $cartProductValues['feVariants'][] = [
                            'sku' => $feVariant->getSku(),
                            'title' => $feVariant->getTitle(),
                            'value' => $feVariantValues[$feVariant->getSku()]
                        ];
                    }
                }
            }

            $newFeVariant = null;
            if ($cartProductValues['feVariants']) {
                $newFeVariant = GeneralUtility::makeInstance(
                    FeVariant::class,
                    $cartProductValues['feVariants']
                );
            }

            $cartProduct = new Product(
                'CartProducts',
                $cartProductValues['productId'],
                $productProduct->getSku(),
                $productProduct->getTitle(),
                $productProduct->getPrice(),
                $this->taxClasses[$productProduct->getTaxClassId()],
                $cartProductValues['quantity'],
                $productProduct->getIsNetPrice(),
                $newFeVariant
            );

            $cartProduct->setMaxNumberInCart($productProduct->getMaxNumberInOrder());
            $cartProduct->setMinNumberInCart($productProduct->getMinNumberInOrder());

            $cartProduct->setSpecialPrice($productProduct->getBestSpecialPrice($frontendUserGroupIds));
            $cartProduct->setQuantityDiscounts($productProduct->getQuantityDiscountArray($frontendUserGroupIds));

            $cartProduct->setStock($productProduct->getStock());
            $cartProduct->setHandleStock($productProduct->isHandleStock());
            $cartProduct->setHandleStockInVariants($productProduct->isHandleStockInVariants());

            $cartProduct->setServiceAttribute1($productProduct->getServiceAttribute1());
            $cartProduct->setServiceAttribute2($productProduct->getServiceAttribute2());
            $cartProduct->setServiceAttribute3($productProduct->getServiceAttribute3());

            if ($productProduct->getProductType() === 'virtual' || $productProduct->getProductType() === 'downloadable') {
                $cartProduct->setIsVirtualProduct(true);
            }

            if (is_array($cartProductValues['additional'])) {
                $cartProduct->setAdditionalArray($cartProductValues['additional']);
            }

            $data = [
                'cartProductValues' => $cartProductValues,
                'productProduct' => $productProduct,
                'cartProduct' => $cartProduct,
            ];

            $signalSlotDispatcher = GeneralUtility::makeInstance(
                Dispatcher::class
            );
            $slotReturn = $signalSlotDispatcher->dispatch(
                __CLASS__,
                'changeNewCartProduct',
                [$data]
            );

            $cartProduct = $slotReturn[0]['cartProduct'];

            $newVariantArr = [];

            if ($cartProductValues['beVariants']) {
                foreach ($cartProductValues['beVariants'] as $variantsKey => $variantsValue) {
                    if ($variantsKey === 1) {
                        $newVariant = $this->createCartBackendVariant(
                            $cartProduct,
                            null,
                            $cartProductValues,
                            $variantsValue
                        );

                        if ($newVariant) {
                            $newVariantArr[$variantsKey] = $newVariant;
                            $cartProduct->addBeVariant($newVariant);
                        } else {
                            break;
                        }
                    } else {
                        $newVariant = $this->createCartBackendVariant(
                            null,
                            $newVariantArr[$variantsKey - 1],
                            $cartProductValues,
                            $variantsValue
                        );

                        if ($newVariant) {
                            $newVariantArr[$variantsKey] = $newVariant;
                            $newVariantArr[$variantsKey - 1]->addBeVariant($newVariant);
                        } else {
                            break;
                        }
                    }
                }
            }
        }

        return $cartProduct;
    }

    /**
     * Get Variant From Repository
     *
     * @param Product $product
     * @param BeVariant $variant
     * @param $cartProductValues
     * @param $variantsValue
     *
     * @return BeVariant|null
     */
    protected function createCartBackendVariant(
        $product,
        $variant,
        $cartProductValues,
        $variantsValue
    ) {
        $cartBackendVariant = null;

        // if value is a integer, get details from database
        if (!is_int($variantsValue) ? (ctype_digit($variantsValue)) : true) {
            $variantId = $variantsValue;
            // creating a new Variant and using Price and Taxclass form CartProduct

            // get further data of variant
            $variantRepository = GeneralUtility::makeInstance(
                BeVariantRepository::class
            );
            /** @var \Extcode\CartProducts\Domain\Model\Product\BeVariant $productBackendVariant */
            $productBackendVariant = $variantRepository->findByUid($variantId);

            if ($productBackendVariant) {
                $frontendUserGroupIds = $this->getFrontendUserGroupIds();

                $bestSpecialPrice = $productBackendVariant->getBestSpecialPrice($frontendUserGroupIds);

                $cartBackendVariant = GeneralUtility::makeInstance(
                    BeVariant::class,
                    $variantId,
                    $product,
                    $variant,
                    $productBackendVariant->getTitle(),
                    $productBackendVariant->getSku(),
                    $productBackendVariant->getPriceCalcMethod(),
                    $productBackendVariant->getPrice(),
                    $cartProductValues['quantity']
                );

                if ($bestSpecialPrice) {
                    $cartBackendVariant->setSpecialPrice($bestSpecialPrice->getPrice());
                }

                $cartBackendVariant->setStock($productBackendVariant->getStock());

                $data = [
                    'cartProductValues' => $cartProductValues,
                    'productBackendVariant' => $productBackendVariant,
                    'cartBackendVariant' => $cartBackendVariant,
                ];

                $signalSlotDispatcher = GeneralUtility::makeInstance(
                    Dispatcher::class
                );
                $slotReturn = $signalSlotDispatcher->dispatch(
                    __CLASS__,
                    'changeNewCartBeVariant',
                    [$data]
                );

                $cartBackendVariant = $slotReturn[0]['cartBackendVariant'];
            }
        }

        return $cartBackendVariant;
    }

    /**
     * @param Cart $cart
     * @param Product $products
     *
     * @return array
     */
    public function checkProductBeforeAddToCart(
        Cart $cart,
        Product $product
    ) {
        list($errors, $product) = $this->checkStockOfProduct($cart, $product);

        $data = [
            'cart' => $cart,
            'product' => $product,
            'errors' => $errors,
        ];

        $signalSlotDispatcher = GeneralUtility::makeInstance(
            Dispatcher::class
        );
        $slotReturn = $signalSlotDispatcher->dispatch(
            __CLASS__,
            __FUNCTION__,
            [$data]
        );

        $products = $slotReturn[0]['products'];
        $errors = $slotReturn[0]['errors'];

        return [$products, $errors];
    }

    /**
     * @param Request $request Request
     *
     * @return array
     */
    public function retrieveCartProductValuesFromRequest(Request $request)
    {
        $cartProductValues = [];

        if ($request->hasArgument('product')) {
            $cartProductValues['productId'] = intval($request->getArgument('product'));
        }
        $cartProductValues['productStorageId'] = 1;
        if ($request->hasArgument('quantity')) {
            $quantity = intval($request->getArgument('quantity'));
            $cartProductValues['quantity'] = $quantity ? $quantity : 1;
        }

        if ($request->hasArgument('feVariants')) {
            $requestFeVariants = $request->getArgument('feVariants');
            if (is_array($requestFeVariants)) {
                foreach ($requestFeVariants as $requestFeVariantKey => $requestFeVariantValue) {
                    $cartProductValues['feVariants'][$requestFeVariantKey] = $requestFeVariantValue;
                }
            }
        }

        if ($request->hasArgument('beVariants')) {
            $requestVariants = $request->getArgument('beVariants');
            if (is_array($requestVariants)) {
                foreach ($requestVariants as $requestVariantKey => $requestVariantValue) {
                    $cartProductValues['beVariants'][$requestVariantKey] = intval($requestVariantValue);
                }
            }
        }

        $data = [
            'request' => $request,
            'cartProductValues' => $cartProductValues,
        ];

        $signalSlotDispatcher = GeneralUtility::makeInstance(
            Dispatcher::class
        );

        $slotReturn = $signalSlotDispatcher->dispatch(
            __CLASS__,
            'changeCartProductValues',
            [$data]
        );

        $cartProductValues = $slotReturn[0]['cartProductValues'];

        return $cartProductValues;
    }

    /**
     * @param Cart $cart
     * @param $productId
     * @param $backendVariantId
     *
     * @return int
     */
    protected function getBackendVariantQuantityFromCart(Cart $cart, $productId, $backendVariantId)
    {
        if ($cart->getProduct($productId)) {
            $cartProduct = $cart->getProduct($productId);
            if ($cartProduct->getBeVariantById($backendVariantId)) {
                $cartBackendVariant = $cartProduct->getBeVariantById($backendVariantId);

                return $cartBackendVariant->getQuantity();
            }
        }
        return 0;
    }

    /**
     * @param Cart $cart
     * @param Product $product
     *
     * @return array
     */
    public function checkStockOfProduct(
        Cart $cart,
        Product $product
    ) {
        $errors = [];

        if ($product->isHandleStock()) {
            if ($product->isHandleStockInVariants()) {
                list($product, $errors) = $this->checkStockOfBackendVariants($cart, $errors, $product);
            } else {
                list($product, $errors) = $this->checkStockOfSimpleProduct($cart, $errors, $product);
            }
        }

        return [$errors, $product];
    }

    /**
     * @param Cart $cart
     * @param array $errors
     * @param $product
     *
     * @return mixed
     */
    protected function checkStockOfSimpleProduct(Cart $cart, $errors, $product)
    {
        $qty = $product->getQuantity();
        if ($cart->getProduct($product->getId())) {
            $qty += $cart->getProduct($product->getId())->getQuantity();
        }

        if ($qty > $product->getStock()) {
            unset($product);

            $message = LocalizationUtility::translate(
                'tx_cartproducts.error.stock_handling.add',
                'cart'
            );
            $error = [
                'message' => $message,
                'severity' => AbstractMessage::ERROR
            ];

            array_push($errors, $error);
        }
        return [$product, $errors];
    }

    /**
     * @param Cart $cart
     * @param array $errors
     * @param $product
     *
     * @return array
     */
    protected function checkStockOfBackendVariants(Cart $cart, $errors, $product)
    {
        if ($product->getBeVariants()) {
            foreach ($product->getBeVariants() as $backendVariant) {
                $qty = $backendVariant->getQuantity();
                $qty += $this->getBackendVariantQuantityFromCart(
                    $cart,
                    $product->getId(),
                    $backendVariant->getId()
                );

                if ($qty > $backendVariant->getStock()) {
                    $product->removeBeVariants([$backendVariant->getId() => 1]);

                    $message = LocalizationUtility::translate(
                        'tx_cartproducts.error.stock_handling.add',
                        'cart'
                    );
                    $error = [
                        'message' => $message,
                        'severity' => AbstractMessage::ERROR
                    ];

                    array_push($errors, $error);
                }
            }
        }
        return [$product, $errors];
    }
}
