<?php

namespace Dustycode\RedditTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class RedditTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ListenForRedditPostsCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-reddit-tile'),
        ], 'dashboard-reddit-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-reddit-tile');

        Livewire::component('reddit-tile', RedditTileComponent::class);
    }
}
