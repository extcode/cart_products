<?php

namespace Extcode\CartProducts\Hooks;

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
     * @param array $params
     * @return bool
     */
    public function checkAvailability(array $params) : bool
    {
        $cartProduct = $params['cartProduct'];
        $quantity = (int)$params['quantity'];

        $this->objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();

        if ($cartProduct->getProductType() != 'CartProducts') {
            return true;
        }
        $this->productRepository = $this->objectManager->get(
            \Extcode\CartProducts\Domain\Repository\Product\ProductRepository::class
        );

        $querySettings = $this->productRepository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->productRepository->setDefaultQuerySettings($querySettings);

        $product = $this->productRepository->findByIdentifier($cartProduct->getProductId());

        if (!$product->isHandleStock()) {
            return true;
        }

        if (!$product->isHandleStockInVariants()) {
            // TODO: add some code here
            return true;
        } else {
            // TODO: add some code here
            return true;
        }

        return false;
    }

    /**
     * @param array $requestArguments
     * @param array $taxClasses
     *
     * @return array
     */
    public function getProductFromRequest(array $requestArguments, array $taxClasses)
    {
        $errors = [];
        $cartProducts = [];
        if (!(int)$requestArguments['product']) {
            // TODO: translation for errors
            $errors[] = [
                'Es wurde kein Produkt übergeben!',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            ];
            return [$errors, $cartProducts];
        }

        $product = $this->productRepository->findByUid((int)$requestArguments['product']);

        // TODO: list($errors, $cartProduct) = $this->productUtility->checkStockOfProduct($this->cart, $cartProduct);
        if (!$errors) {
            $this->cart->addProduct($cartProduct);

            $this->cartUtility->writeCartToSession($this->cart, $this->cartFrameworkConfig['settings']);
        }

        return [$errors, $cartProducts];
    }

    /**
     * Action Add
     *
     * @return string
     */
    public function addAction()
    {
        $this->cartUtility->writeCartToSession($this->cart, $this->cartFrameworkConfig['settings']);

        if (!$errors) {
            $this->cart->addProduct($cartProduct);

            $this->cartUtility->writeCartToSession($this->cart, $this->cartFrameworkConfig['settings']);

            $message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_cartproducts.plugin.form.submit.success',
                'cart_products'
            );

            if (isset($_GET['type'])) {
                $response = [
                    'status' => '200',
                    'count' => $this->cart->getCount(),
                    'net' => $this->cart->getNet(),
                    'gross' => $this->cart->getGross(),
                    'messageBody' => $message,
                    'messageTitle' => '',
                    'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
                ];

                return json_encode($response);
            } else {
                $this->addFlashMessage(
                    $message,
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
                    true
                );
            }
        } else {
            $message = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_cartproducts.plugin.form.submit.error',
                'cart_products'
            );
            $message .= ' ';

            if (is_array($errors)) {
                foreach ($errors as $error) {
                    if ($error['message']) {
                        $message .= $error['message'] . ' ';

                        //$severity = !empty($error['severity']) ? $error['severity'] : $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING;
                    }
                }
            }

            if (isset($_GET['type'])) {
                $response = [
                    'status' => '400',
                    'count' => $this->cart->getCount(),
                    'net' => $this->cart->getNet(),
                    'gross' => $this->cart->getGross(),
                    'messageBody' => $message,
                    'messageTitle' => '',
                    'severity' => \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
                ];

                return json_encode($response);
            } else {
                $this->addFlashMessage(
                    $message,
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
                    true
                );
            }
        }

        $this->redirect('show', 'Product', null, ['product'=> $product]);
    }
}
