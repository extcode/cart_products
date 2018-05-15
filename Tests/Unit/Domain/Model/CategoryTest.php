<?php

namespace Extcode\CartProducts\Tests\Domain\Model;

use Extcode\CartProducts\Domain\Model\Category;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CategoryTest extends UnitTestCase
{

    /**
     * @var Category
     */
    protected $category = null;

    protected function setUp()
    {
        $this->category = new Category();
    }

    protected function tearDown()
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
