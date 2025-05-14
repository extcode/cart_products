<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\Model;

use WerkraumMedia\Watchlist\Domain\Model\Item;

final class WatchlistItem implements Item
{
    private readonly string $type;

    public function __construct(
        private readonly int $uid,
        private readonly int $detailPid,
        private readonly string $title,
    ) {
        $this->type = 'CartProducts';
    }

    public function getUniqueIdentifier(): string
    {
        return $this->type . '-' . $this->uid . '-' . $this->detailPid;
    }

    public function getType(): string
    {
        return $this->type;
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
}
