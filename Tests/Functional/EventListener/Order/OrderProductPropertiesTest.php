<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Functional\EventListener\Order;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codappix\Typo3PhpDatasets\TestingFramework;
use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Domain\Model\Cart\TaxClass;
use Extcode\Cart\Domain\Model\Order\Item;
use Extcode\Cart\Domain\Model\Order\Product as OrderProduct;
use Extcode\Cart\Event\Order\BeforePersistOrderProductEvent;
use Extcode\CartProducts\EventListener\Order\OrderProductProperties;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(OrderProductProperties::class)]
final class OrderProductPropertiesTest extends FunctionalTestCase
{
    use TestingFramework;

    protected array $testExtensionsToLoad = [
        'extcode/cart',
        'extcode/cart-products',
    ];

    protected array $coreExtensionsToLoad = [
        'typo3/cms-reactions',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->importPHPDataSet(__DIR__ . '/../../Fixtures/Pages.php');
        $this->importPHPDataSet(__DIR__ . '/../../Fixtures/Products.php');
    }

    #[Test]
    public function productIsShippableCancelableAndReturnableByDefault(): void
    {
        $event = $this->dispatch('CartProducts', 1);

        self::assertTrue($event->isShippable());
        self::assertTrue($event->isCancelable());
        self::assertTrue($event->isReturnable());
    }

    #[Test]
    public function takesOverCancelableAndReturnableOfTheProduct(): void
    {
        $this->updateProduct(1, ['cancelable' => 0, 'returnable' => 0]);
        $this->updateProduct(2, ['cancelable' => 1, 'returnable' => 0]);

        $first = $this->dispatch('CartProducts', 1);
        $second = $this->dispatch('CartProducts', 2);

        self::assertFalse($first->isCancelable());
        self::assertFalse($first->isReturnable());
        self::assertTrue($second->isCancelable());
        self::assertFalse($second->isReturnable());
    }

    #[Test]
    public function takesOverShippableOfAPhysicalProduct(): void
    {
        $this->updateProduct(1, ['shippable' => 0]);

        $event = $this->dispatch('CartProducts', 1);

        self::assertFalse($event->isShippable());
        self::assertTrue($event->isCancelable());
        self::assertTrue($event->isReturnable());
    }

    #[Test]
    public function virtualProductStaysNotShippable(): void
    {
        $this->updateProduct(1, ['shippable' => 1]);

        self::assertFalse($this->dispatch('CartProducts', 1, true)->isShippable());
    }

    #[Test]
    public function takesOverThePropertiesOfAProductHiddenAfterItWasPutIntoTheCart(): void
    {
        $this->updateProduct(1, ['cancelable' => 0, 'hidden' => 1]);

        self::assertFalse($this->dispatch('CartProducts', 1)->isCancelable());
    }

    #[Test]
    public function keepsTheDefaultsForProductsOfOtherExtensions(): void
    {
        $this->updateProduct(1, ['shippable' => 0, 'cancelable' => 0, 'returnable' => 0]);

        $event = $this->dispatch('CartEvents', 1);

        self::assertTrue($event->isShippable());
        self::assertTrue($event->isCancelable());
        self::assertTrue($event->isReturnable());
    }

    #[Test]
    public function keepsTheDefaultsIfTheProductDoesNotExist(): void
    {
        $event = $this->dispatch('CartProducts', 999);

        self::assertTrue($event->isShippable());
        self::assertTrue($event->isCancelable());
        self::assertTrue($event->isReturnable());
    }

    private function dispatch(string $productType, int $productId, bool $isVirtualProduct = false): BeforePersistOrderProductEvent
    {
        $cartProduct = new CartProduct(
            $productType,
            $productId,
            'sku',
            'Title',
            10.0,
            new TaxClass(1, '19', 0.19, 'normal'),
            1
        );
        $cartProduct->setIsVirtualProduct($isVirtualProduct);

        $event = new BeforePersistOrderProductEvent(
            new Item(),
            new OrderProduct(),
            $cartProduct,
            null,
            !$isVirtualProduct,
            true,
            true
        );

        $eventDispatcher = $this->get(EventDispatcherInterface::class);
        self::assertInstanceOf(EventDispatcherInterface::class, $eventDispatcher);
        $eventDispatcher->dispatch($event);

        return $event;
    }

    /**
     * @param array<string, int> $values
     */
    private function updateProduct(int $uid, array $values): void
    {
        $table = 'tx_cartproducts_domain_model_product_product';
        $this->getConnectionPool()->getConnectionForTable($table)->update($table, $values, ['uid' => $uid]);
    }
}
