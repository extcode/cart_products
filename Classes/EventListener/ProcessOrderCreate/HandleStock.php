<?php
declare(strict_types=1);
namespace Extcode\CartProducts\EventListener\ProcessOrderCreate;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Cart\Product as CartProduct;
use Extcode\Cart\Event\ProcessOrderCreateEvent;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class HandleStock extends \Extcode\CartProducts\EventListener\Order\Stock\HandleStock
{
}
