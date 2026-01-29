<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model;

use Extcode\CartProducts\Domain\Model\Category;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CategoryTest extends UnitTestCase
{
    /**
     * @var Category
     */
    protected $category;

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
    public function getCartProductShowPidReturnsShowPid(): void
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

        self::assertEquals(
            $cartProductShowPid,
            $category->getCartProductShowPid()
        );
    }

    /**
     * Creates a mock object which allows for calling protected methods and access of protected properties.
     *
     * Note: This method has no native return types on purpose, but only PHPDoc return type annotations.
     * The reason is that the combination of "union types with generics in PHPDoc" and "a subset of those types as
     * native types, but without the generics" tends to confuse PhpStorm's static type analysis (which we want to avoid).
     *
     * @template T of object
     * @param class-string<T> $originalClassName name of class to create the mock object of
     * @param string[]|null $methods name of the methods to mock, null for "mock no methods"
     * @param array $arguments arguments to pass to constructor
     * @param string $mockClassName the class name to use for the mock class
     * @param bool $callOriginalConstructor whether to call the constructor
     * @param bool $callOriginalClone whether to call the __clone method
     * @param bool $callAutoload whether to call any autoload function
     *
     * @return MockObject&AccessibleObjectInterface&T a mock of `$originalClassName` with access methods added
     *
     * @throws \InvalidArgumentException
     */
    protected function getAccessibleMock(
        string $originalClassName,
        ?array $methods = [],
        array $arguments = [],
        string $mockClassName = '',
        bool $callOriginalConstructor = true,
        bool $callOriginalClone = true,
        bool $callAutoload = true
    ) {
        $mockBuilder = $this->getMockBuilder($this->buildAccessibleProxy($originalClassName))
            ->addMethods($methods)
            ->setConstructorArgs($arguments)
            ->setMockClassName($mockClassName);

        if (!$callOriginalConstructor) {
            $mockBuilder->disableOriginalConstructor();
        }

        if (!$callOriginalClone) {
            $mockBuilder->disableOriginalClone();
        }

        if (!$callAutoload) {
            $mockBuilder->disableAutoload();
        }

        return $mockBuilder->getMock();
    }
}
