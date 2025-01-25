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

        $I->seeLink('Simple Product 1', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=1&cHash=dab405401f299c9d90714d1f82893541');
        $I->see('9,99 €');
        $I->seeLink('Simple Product 2', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=2&cHash=d613d866189744dc46ff2a6be165b328');
        $I->see('19,99 €');
        $I->seeLink('Simple Product 5', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=10&cHash=615b860ea077f52b0effad2348512845');
        $I->see('29,99 €');
        $I->seeLink('Simple Product 3', '/product-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=3&cHash=672f872da3eb11fdbb9acd7e7d1c827a');
        $I->see('29,99 €');

        $I->seeAboveInPageSource('Simple Product 1', 'Simple Product 2');
        $I->seeAboveInPageSource('Simple Product 2', 'Simple Product 5');
        $I->seeAboveInPageSource('Simple Product 5', 'Simple Product 3');
    }

    public function testTranslatedProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/de/produkt-teaser/');

        $I->seeLink('Einfaches Produkt 1', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=1&cHash=dab405401f299c9d90714d1f82893541');
        $I->see('9,99 €');
        $I->seeLink('Einfaches Produkt 5', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=10&cHash=615b860ea077f52b0effad2348512845');
        $I->see('29,99 €');
        $I->seeLink('Einfaches Produkt 3', '/de/produkt-teaser?tx_cartproducts_teaserproducts%5Baction%5D=show&tx_cartproducts_teaserproducts%5Bcontroller%5D=Product&tx_cartproducts_teaserproducts%5Bproduct%5D=3&cHash=672f872da3eb11fdbb9acd7e7d1c827a');
        $I->see('29,99 €');

        $I->seeAboveInPageSource('Einfaches Produkt 1', 'Einfaches Produkt 5');
        $I->seeAboveInPageSource('Einfaches Produkt 5', 'Einfaches Produkt 3');
    }
}
