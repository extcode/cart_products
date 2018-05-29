<?php

namespace Extcode\CartProducts\Hooks;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class CartProductHook implements \Extcode\Cart\Hooks\CartProductHookInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Product Repository
     *
     * @var \Extcode\CartProducts\Domain\Repository\Product\ProductRepository
     */
    protected $productRepository;

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Web\Request $request
     * @param \Extcode\Cart\Domain\Model\Cart\Product $cartProduct
     * @param \Extcode\Cart\Domain\Model\Cart\Cart $cart
     * @param string $mode
     *
     * @return \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse
     */
    public function checkAvailability(
        \TYPO3\CMS\Extbase\Mvc\Web\Request $request,
        \Extcode\Cart\Domain\Model\Cart\Product $cartProduct,
        \Extcode\Cart\Domain\Model\Cart\Cart $cart,
        string $mode = 'update'
    ) : \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse {
        $this->objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();

        $availabilityResponse = GeneralUtility::makeInstance(
            \Extcode\Cart\Domain\Model\Dto\AvailabilityResponse::class
        );

        if ($cartProduct->getProductType() != 'CartProducts') {
            return $availabilityResponse;
        }
        $this->productRepository = $this->objectManager->get(
            \Extcode\CartProducts\Domain\Repository\Product\ProductRepository::class
        );

        $querySettings = $this->productRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->productRepository->setDefaultQuerySettings($querySettings);

        $product = $this->productRepository->findByIdentifier($cartProduct->getProductId());

        if (!$product->isHandleStock()) {
            return $availabilityResponse;
        }

        if ($request->hasArgument('quantities')) {
            $quantities = $request->getArgument('quantities');
            $quantities = $quantities[$cartProduct->getId()];
        } else {
            if ($request->hasArgument('quantity')) {
                if ($request->hasArgument('beVariants')) {
                    $quantities[$request->getArgument('beVariants')[1]] = $request->getArgument('quantity');
                } else {
                    $quantities = $request->getArgument('quantity');
                }
            }
        }

        if (!$product->isHandleStockInVariants()) {
            $quantity = (int)$quantities;

            if (($mode == 'add') && $cart->getProduct($cartProduct->getId())) {
                $quantity += $cart->getProduct($cartProduct->getId())->getQuantity();
            }

            if ($quantity > $product->getStock()) {
                $availabilityResponse->setAvailable(false);
                $flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Messaging\FlashMessage::class,
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'tx_cart.error.stock_handling.update',
                        'cart'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $availabilityResponse->addMessage($flashMessage);
            }

            return $availabilityResponse;
        } else {
            foreach ($product->getBeVariants() as $beVariant) {
                $quantity = (int)$quantities[$beVariant->getUid()];
                if (($mode == 'add') && $cart->getProduct($cartProduct->getId())) {
                    if ($cart->getProduct($cartProduct->getId())->getBeVariant($beVariant->getUid())) {
                        $quantity += (int)$cart->getProduct($cartProduct->getId())->getBeVariant($beVariant->getUid())->getQuantity();
                    }
                }
                if ($quantity > $beVariant->getStock()) {
                    $availabilityResponse->setAvailable(false);
                    $flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                        \TYPO3\CMS\Core\Messaging\FlashMessage::class,
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_cart.error.stock_handling.update',
                            'cart'
                        ),
                        '',
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                    );

                    $availabilityResponse->addMessage($flashMessage);
                }
            }

            return $availabilityResponse;
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\Web\Request $request
     * @param \Extcode\Cart\Domain\Model\Cart\Cart $cart
     *
     * @return array
     */
    public function getProductFromRequest(
        \TYPO3\CMS\Extbase\Mvc\Web\Request $request,
        \Extcode\Cart\Domain\Model\Cart\Cart $cart
    ) {
        $requestArguments = $request->getArguments();
        $taxClasses = $cart->getTaxClasses();

        $errors = $this->checkRequestArguments($requestArguments);

        if (!empty($errors)) {
            return [$errors, []];
        }

        $this->objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();

        $productUtility = $this->objectManager->get(
            \Extcode\CartProducts\Utility\ProductUtility::class
        );
        $productUtility->setTaxClasses($taxClasses);

        $cartProduct = $productUtility->getProductFromRequest($request, $cart->getTaxClasses());

        return [[], [$cartProduct]];
    }

    /**
     * @param array $requestArguments
     *
     * @return array
     */
    protected function checkRequestArguments(array $requestArguments)
    {
        if (!(int)$requestArguments['product']) {
            return [
                'messageBody' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cart.error.parameter.no_product',
                    'cart_products'
                ),
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            ];
        }

        if ((int)$requestArguments['quantity'] < 0) {
            return [
                'messageBody' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_cart.error.invalid_quantity',
                    'cart_products'
                ),
                'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
            ];
        }
    }
}
