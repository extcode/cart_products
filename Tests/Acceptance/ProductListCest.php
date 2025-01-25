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

        $I->seeLink('Simple Product 1', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=1&cHash=275cce22d935c04473314c31f46f7ada');
        $I->see('9,99 €');
        $I->seeLink('Simple Product 2', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=2&cHash=36af38e6c5bbac81dcd80c3a3c53f4a1');
        $I->see('19,99 €');
        $I->seeLink('Simple Product 3', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=3&cHash=499063e1c85e8b41785e04d33a20e2db');
        $I->see('29,99 €');

        $I->dontSee('Simple Product 4');

        $I->click('Simple Product 1');
        $I->see('Simple Product 1', 'h1');
        $I->see('10', '.in-stock');
    }

    public function testRelatedProductLinksOnListPluginDetailView(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');

        $I->click('Simple Product 1');
        $I->see('Simple Product 1', 'h1');

        $I->seeLink('Simple Product 2', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=2&cHash=36af38e6c5bbac81dcd80c3a3c53f4a1');
        $I->dontSee('Simple Product 3', 'a');
        $I->seeLink('Simple Product With Detail Page', '/detail-page-for-simple-product-with-detail-page');

        $I->click('Simple Product With Detail Page');
        $I->see('Simple Product With Detail Page', 'h1');

        $I->seeLink('Simple Product 1', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=1&cHash=275cce22d935c04473314c31f46f7ada');
        $I->dontSee('Simple Product 2', 'a');
        $I->dontSee('Simple Product 3', 'a');

    }

    public function testProductListAndDetailViewForConfigurableProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');
        $I->seeLink('Configurable Product 1', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=5&cHash=4c2d7ef7c3ec394907ad93a1a0434fc8');
        $I->see('99,99 €');
        $I->seeLink('Configurable Product 2', '/product?tx_cartproducts_showproduct%5Baction%5D=show&tx_cartproducts_showproduct%5Bcontroller%5D=Product&tx_cartproducts_showproduct%5Bproduct%5D=6&cHash=93520e7d2c5c85e6563ce0e5b8eba102');
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

    public function testDifferentPricesAndStockForConfigurableProducts(Tester $I): void
    {
        $I->amOnUrl('http://127.0.0.1:8080/products/');
        $I->see('Configurable Product 2');
        $I->click('Configurable Product 2');

        $xpath = '//select[@id="be-variants-select"]/option';

        // Test prices
        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 6), 'data-regular-price');
        $expectedPrice = html_entity_decode('149,49&nbsp;&euro;');
        assertEquals($expectedPrice, $regularPrice);

        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 7), 'data-regular-price');
        $expectedPrice = html_entity_decode('169,99&nbsp;&euro;');
        assertEquals($expectedPrice, $regularPrice);

        $regularPrice = $I->grabAttributeFrom(Locator::elementAt($xpath, 8), 'data-regular-price');
        $expectedPrice = html_entity_decode('149,49&nbsp;&euro;');
        assertEquals($expectedPrice, $regularPrice);

        // Test stock
        $stock = $I->grabAttributeFrom(Locator::elementAt($xpath, 6), 'data-available-stock');
        $expectedStock = '5';
        assertEquals($expectedStock, $stock);

        $stock = $I->grabAttributeFrom(Locator::elementAt($xpath, 7), 'data-available-stock');
        $expectedStock = '6';
        assertEquals($expectedStock, $stock);

        $stock = $I->grabAttributeFrom(Locator::elementAt($xpath, 8), 'data-available-stock');
        $expectedStock = '7';
        assertEquals($expectedStock, $stock);
    }
}
