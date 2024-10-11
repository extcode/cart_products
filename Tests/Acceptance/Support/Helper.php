<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Acceptance\Support;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codeception\Module;
use Codeception\Module\WebDriver;
use Exception;

class Helper extends Module
{
    public function seeAboveInPageSource($above, $below): void
    {
        $text = $this->getWebDriver()->grabTextFrom('body');

        $this->assertRegExp("/$above.*$below/s", $text);
    }

    private function getWebDriver(): WebDriver
    {
        $webDriver = $this->moduleContainer->getModule('WebDriver');

        if (!$webDriver instanceof WebDriver) {
            throw new Exception('Could not retrieve WebDriver module.', 1728471395);
        }

        return $webDriver;
    }
}
