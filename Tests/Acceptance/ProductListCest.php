<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Acceptance;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codeception\Util\Locator;
use Extcode\CartProducts\Tests\Acceptance\Support\Tester;

use function PHPUnit\Framework\assertEquals;

class ProductListCest
{
    public function testProductListAndDetailViewForSimpleProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');

        $I->see('Simple Product 1');
        $I->see('9,99 €');
        $I->see('Simple Product 2');
        $I->see('19,99 €');
        $I->see('Simple Product 3');
        $I->see('29,99 €');

        $I->dontSee('Simple Product 4');

        $I->click('Simple Product 1');
        $I->see('Simple Product 1', 'h1');
    }

    public function testProductListAndDetailViewForConfigurableProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');
        $I->see('Configurable Product 1');
        $I->see('99,99 €');
        $I->see('Configurable Product 2');
        $I->see('149,49 €');

        $I->click('Configurable Product 1');
        $I->see('Configurable Product 1', 'h1');
        $I->see('Please choose ...', 'select');

        $xpath = '//select[@id="be-variants-select"]/option';
        $arrayOfSelectOptions = $I->grabMultiple($xpath);

        // check number of backend variants
        $sumSelectOptions = count($arrayOfSelectOptions);
        $I->comment("In selector are $sumSelectOptions options");
        assertEquals(4, $sumSelectOptions);

        // check sorting of backend variants
        assertEquals('red', $arrayOfSelectOptions[1]);
        assertEquals('blue', $arrayOfSelectOptions[2]);
        assertEquals('green', $arrayOfSelectOptions[3]);
    }

    public function testDifferentPricesForConfigurableProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');
        $I->see('Configurable Product 2');
        $I->click('Configurable Product 2');

        $xpath = '//select[@id="be-variants-select"]/option';

        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 6), 'data-regular-price');
        assertEquals('149,49 €', $regularPrice);
        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 7), 'data-regular-price');
        assertEquals('169,99 €', $regularPrice);
        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 8), 'data-regular-price');
        assertEquals('149,49 €', $regularPrice);
    }
}
