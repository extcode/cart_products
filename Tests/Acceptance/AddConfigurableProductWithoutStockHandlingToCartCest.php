<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Acceptance;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Tests\Acceptance\Support\Tester;

class AddConfigurableProductWithoutStockHandlingToCartCest
{
    public function testAddDifferentItemsToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=5&cHash=4c2d7ef7c3ec394907ad93a1a0434fc8');

        $I->see('Configurable Product 1', 'h1');
        $I->dontSeeElement('#product-price .in-stock');

        $I->dontSeeElement('#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'red');
        $I->click('#product-5.add-to-cart-form input.btn[type="submit"]');

        $I->see('Item was added to cart.', '#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 2);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'green');
        $I->click('#product-5.add-to-cart-form input.btn[type="submit"]');

        $I->see('2 Items were added to cart.', '#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 100);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'red');
        $I->click('#product-5.add-to-cart-form input.btn[type="submit"]');

        $I->see('100 Items were added to cart.', '#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-5 .form-message .form-success');
        $I->dontSeeElement('#product-5 .form-message .form-error');
    }
}
