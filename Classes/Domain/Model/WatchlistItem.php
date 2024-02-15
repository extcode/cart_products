<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\Model;

use WerkraumMedia\Watchlist\Domain\Model\Item;

class WatchlistItem implements Item
{
    /**
     * @var string
     */
    private $type = 'CartProducts';

    /**
     * @var int
     */
    private $uid;

    /**
     * @var int
     */
    private $detailPid;

    /**
     * @var string
     */
    private $title;

    public function __construct(
        int $uid,
        int $detailPid,
        string $title
    ) {
        $this->uid = $uid;
        $this->detailPid = $detailPid;
        $this->title = $title;
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
