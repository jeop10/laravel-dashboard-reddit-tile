<?php

namespace Dustycode\RedditTile;

use Spatie\Dashboard\Models\Tile;

class RedditStore {

    private Tile $tile;

    public static function make(string $configurationName)
    {
        return new static($configurationName);
    }

    public function __construct(string $configurationName)
    {
        $this->tile = Tile::firstOrCreateForName("reddit_{$configurationName}");
    }

    public function things()
    {
        return $this->tile->getData('things');
    }
}
