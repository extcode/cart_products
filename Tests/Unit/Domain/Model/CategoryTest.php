<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model;

use Extcode\CartProducts\Domain\Model\Category;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CategoryTest extends UnitTestCase
{

    /**
     * @var Category
     */
    protected $category = null;

    protected function setUp(): void
    {
        $this->category = new Category();
    }

    protected function tearDown(): void
    {
        unset($this->category);
    }

    /**
     * @test
     */
    public function getCartProductShowPidReturnsShowPid()
    {
        $cartProductShowPid = 123;

        $category = $this->getAccessibleMock(
            Category::class,
            ['dummy'],
            [],
            '',
            false
        );

        $category->_set('cartProductShowPid', $cartProductShowPid);

        $this->assertEquals(
            $cartProductShowPid,
            $category->getCartProductShowPid()
        );
    }
}
