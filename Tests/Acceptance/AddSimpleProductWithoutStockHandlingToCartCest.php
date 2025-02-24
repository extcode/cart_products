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

class AddSimpleProductWithoutStockHandlingToCartCest
{
    public function testAddDifferentItemsToCart(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=2&cHash=36af38e6c5bbac81dcd80c3a3c53f4a1');

        $I->see('Simple Product 2', 'h1');
        $I->dontSeeElement('#product-price .in-stock');

        $I->dontSeeElement('#product-2 .form-message .form-success');
        $I->dontSeeElement('#product-2 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 1);
        $I->click('#product-2.add-to-cart-form input.btn[type="submit"]');

        $I->see('Item was added to cart.', '#product-2 .form-message .form-success');
        $I->dontSeeElement('#product-2 .form-message .form-error');

        $I->waitForElementNotVisible('#product-2 .form-message .form-success');
        $I->waitForElementNotVisible('#product-2 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 2);
        $I->click('#product-2.add-to-cart-form input.btn[type="submit"]');

        $I->see('2 Items were added to cart.', '#product-2 .form-message .form-success');
        $I->dontSeeElement('#product-2 .form-message .form-error');

        $I->waitForElementNotVisible('#product-2 .form-message .form-success');
        $I->waitForElementNotVisible('#product-2 .form-message .form-error');

        $I->fillField('tx_cart_cart[quantity]', 100);
        $I->click('#product-2.add-to-cart-form input.btn[type="submit"]');

        $I->see('100 Items were added to cart.', '#product-2 .form-message .form-success');
        $I->dontSeeElement('#product-2 .form-message .form-error');

        $I->waitForElementNotVisible('#product-2 .form-message .form-success');
        $I->waitForElementNotVisible('#product-2 .form-message .form-error');
    }
}
