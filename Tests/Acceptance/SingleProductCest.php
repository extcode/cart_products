<?php

namespace Extcode\CartProducts\Tests\Acceptance;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Tests\Acceptance\Support\Tester;

class SingleProductCest
{
    public function testProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');

        $I->see('Simple Product With Detail Page');

        $I->click('Simple Product With Detail Page');
        $I->seeCurrentUrlEquals('/detail-page-for-simple-product-with-detail-page');
        $I->see('Simple Product With Detail Page', 'h1');
    }

    public function testTranslatedProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/de/produkte/');

        $I->see('Einfaches Produkt Mit Detailseite');

        $I->click('Einfaches Produkt Mit Detailseite');
        $I->seeCurrentUrlEquals('/de/detailseite-fuer-einfaches-produkt-mit-detailseite');
        $I->see('Einfaches Produkt Mit Detailseite', 'h1');
    }
}
