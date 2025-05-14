<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\Model;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use WerkraumMedia\Watchlist\Domain\Model\Item;

readonly class WatchlistItem implements Item
{
    private const TYPE = 'CartProducts';

    public function __construct(
        private int $uid,
        private int $detailPid,
        private string $title,
        private ?int $fileReference = null,
    ) {}

    public function getUniqueIdentifier(): string
    {
        return self::TYPE . '-' . $this->uid . '-' . $this->detailPid;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function getDetailPid(): int
    {
        return $this->detailPid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFileReference(): ?int
    {
        return $this->fileReference;
    }
}
