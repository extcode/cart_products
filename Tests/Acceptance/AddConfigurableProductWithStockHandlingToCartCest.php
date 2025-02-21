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

class AddConfigurableProductWithStockHandlingToCartCest
{
    public function testAddDifferentItemsWithinAvailableAmountToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=6&cHash=93520e7d2c5c85e6563ce0e5b8eba102');

        $I->see('Configurable Product 2', 'h1');
        $I->see(' ', '#product-price .in-stock');

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'XL - red');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (5 pieces)', '#product-price .in-stock');

        $I->see('Item was added to cart.', '#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 2);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'M - green');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (3 pieces)', '#product-price .in-stock');

        $I->see('2 Items were added to cart.', '#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 4);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'XL - red');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (5 pieces)', '#product-price .in-stock');

        $I->see('4 Items were added to cart.', '#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
    }

    public function testAddMoreItemsThanInStockOfASimpleProductToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=6&cHash=93520e7d2c5c85e6563ce0e5b8eba102');

        $I->see('Configurable Product 2', 'h1');
        $I->see(' ', '#product-price .in-stock');

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 6);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'XL - red');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (5 pieces)', '#product-price .in-stock');

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->see('Desired number of this item not available.', '#product-6 .form-message .form-error');

        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
    }

    public function testAddOneAndThanMoreItemsThanInStockOfASimpleProductToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=6&cHash=93520e7d2c5c85e6563ce0e5b8eba102');

        $I->see('Configurable Product 2', 'h1');
        $I->see(' ', '#product-price .in-stock');

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'XL - red');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (5 pieces)', '#product-price .in-stock');

        $I->see('Item was added to cart.', '#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 5);
        $I->selectOption('tx_cart_cart[beVariants][1]', 'XL - red');
        $I->click('#product-6.add-to-cart-form input.btn[type="submit"]');
        $I->see('In stock (5 pieces)', '#product-price .in-stock');

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->see('Desired number of this item not available.', '#product-6 .form-message .form-error');

        $I->wait(3);

        $I->dontSeeElement('#product-6 .form-message .form-success');
        $I->dontSeeElement('#product-6 .form-message .form-error');
    }
}
