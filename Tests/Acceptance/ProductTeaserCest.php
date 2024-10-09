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

        $I->see('Simple Product 1');
        $I->see('9,99 €');
        $I->see('Simple Product 2');
        $I->see('19,99 €');
        $I->see('Simple Product 3');
        $I->see('29,99 €');
    }

    public function testTranslatedProductTeaserViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/de/produkt-teaser/');

        $I->see('Einfaches Produkt 1');
        $I->see('9,99 €');
        $I->see('Einfaches Produkt 3');
        $I->see('29,99 €');
    }
}
