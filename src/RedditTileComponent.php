<?php

namespace Dustycode\RedditTile;

use Livewire\Component;

class RedditTileComponent extends Component
{
    /** @var string */
    public $position;

    /** @var string|null */
    public $title;

    /** @var string */
    public $configurationName;

    public function mount(string $position, ?string $title = null, string $configurationName = 'default')
    {
        $this->position = $position;
        $this->title = $title;
        $this->configurationName = $configurationName;
    }

    public function render()
    {
        $config = config("dashboard.tiles.reddit.configurations.{$this->configurationName}");

        if (! isset($config['subreddit'])
            || ! isset($config['refresh_interval_in_seconds'])
        ) {
            throw new \Exception('config parameters missing on Reddit tile');
        }

        return view('dashboard-reddit-tile::tile', [
            'things' => RedditStore::make($this->configurationName)->things(),
            'sort' => $config['sort_by'],
            'refreshIntervalInSeconds' => $config['refresh_interval_in_seconds'] ?? 60,
        ]);
    }
}
