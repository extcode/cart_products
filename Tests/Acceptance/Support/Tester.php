<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Acceptance\Support;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codeception\Actor;
use Extcode\CartProducts\Tests\Acceptance\Support\_generated\TesterActions;
use TYPO3\TestingFramework\Core\Acceptance\Step\FrameSteps;

/**
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 */
class Tester extends Actor
{
    use TesterActions;

    use FrameSteps;

    protected int $retryNum = 2;
}
