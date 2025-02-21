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

class AddSimpleProductToCartCest
{
    public function testAddOneAndTwoItemsOfASimpleProductToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=1&cHash=275cce22d935c04473314c31f46f7ada');

        $I->see('Simple Product 1', 'h1');
        $I->see('10', '#product-price .in-stock');

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->click('#product-1.add-to-cart-form input.btn[type="submit"]');

        $I->see('Item was added to cart.', '#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 2);
        $I->click('#product-1.add-to-cart-form input.btn[type="submit"]');

        $I->see('2 Items were added to cart.', '#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
    }

    public function testAddMoreItemsThanInStockOfASimpleProductToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=1&cHash=275cce22d935c04473314c31f46f7ada');

        $I->see('Simple Product 1', 'h1');
        $I->see('10', '#product-price .in-stock');

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 11);
        $I->click('#product-1.add-to-cart-form input.btn[type="submit"]');

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->see('Desired number of this item not available.', '#product-1 .form-message .form-error');

        $I->wait(3);

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
    }

    public function testAddOneAndThanMoreItemsThanInStockOfASimpleProductToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=1&cHash=275cce22d935c04473314c31f46f7ada');

        $I->see('Simple Product 1', 'h1');
        $I->see('10', '#product-price .in-stock');

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->click('#product-1.add-to-cart-form input.btn[type="submit"]');

        $I->see('Item was added to cart.', '#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 10);
        $I->click('#product-1.add-to-cart-form input.btn[type="submit"]');

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->see('Desired number of this item not available.', '#product-1 .form-message .form-error');

        $I->wait(3);

        $I->dontSeeElement('#product-1 .form-message .form-success');
        $I->dontSeeElement('#product-1 .form-message .form-error');
    }
}
