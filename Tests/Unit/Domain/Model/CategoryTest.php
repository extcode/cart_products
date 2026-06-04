<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model;

use Extcode\CartProducts\Domain\Model\Category;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CategoryTest extends UnitTestCase
{
    #[Test]
    public function getCartProductShowPidReturnsShowPid(): void
    {
        $cartProductShowPid = 123;

        $category = new Category();
        $reflection = new \ReflectionClass($category);
        $property = $reflection->getProperty('cartProductShowPid');
        $property->setValue($category, $cartProductShowPid);

        self::assertEquals(
            $cartProductShowPid,
            $category->getCartProductShowPid()
        );
    }
}
