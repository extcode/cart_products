<?php

namespace Extcode\CartProducts\Tests\Acceptance;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Tests\Acceptance\Support\Tester;

class ProductTeaserCest
{
    public function testProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/product-teaser/');

        $I->seeLink('Simple Product 1', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=1&cHash=058c3485d31e466bb10915666308ba082ad838b4c8c3bf8b31168c29106f5add');
        $I->see('9,99 €');
        $I->seeLink('Simple Product 2', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=2&cHash=702e6da32eafeb6d0ecb7849f659005ffecf5b6fa321ea6db1f9332730cdf3b6');
        $I->see('19,99 €');
        $I->seeLink('Simple Product 5', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=10&cHash=cddbcf233521c83c6d0481d8f753afae8de0db9f02295d328c4286a3369cb2a9');
        $I->see('29,99 €');
        $I->seeLink('Simple Product 3', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=3&cHash=688c9b64a005db1b72153619c3b66f33735297648de046c338c851b13e9b6cd8');
        $I->see('29,99 €');

        $I->seeAboveInPageSource('Simple Product 1', 'Simple Product 2');
        $I->seeAboveInPageSource('Simple Product 2', 'Simple Product 5');
        $I->seeAboveInPageSource('Simple Product 5', 'Simple Product 3');
    }

    public function testTranslatedProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/de/produkt-teaser/');

        $I->seeLink('Einfaches Produkt 1', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=1&cHash=058c3485d31e466bb10915666308ba082ad838b4c8c3bf8b31168c29106f5add');
        $I->see('9,99 €');
        $I->seeLink('Einfaches Produkt 5', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=10&cHash=cddbcf233521c83c6d0481d8f753afae8de0db9f02295d328c4286a3369cb2a9');
        $I->see('29,99 €');
        $I->seeLink('Einfaches Produkt 3', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=3&cHash=688c9b64a005db1b72153619c3b66f33735297648de046c338c851b13e9b6cd8');
        $I->see('29,99 €');

        $I->seeAboveInPageSource('Einfaches Produkt 1', 'Einfaches Produkt 5');
        $I->seeAboveInPageSource('Einfaches Produkt 5', 'Einfaches Produkt 3');
    }
}
