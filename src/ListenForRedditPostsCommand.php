<?php

namespace Dustycode\RedditTile;

use Illuminate\Console\Command;
use Spatie\Dashboard\Models\Tile;

class ListenForRedditPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:listen-reddit-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for reddit posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $configurations = config("dashboard.tiles.reddit.configurations");


        if (is_null($configurations)) {
            $this->error("There is no configuration");

            return -1;
        }

        foreach ($configurations as $key => $config) {
            $this->info("Listening for posts on subreddit:  r/{$config['subreddit']}");


            $things = RedditClient::make()
                ->subReddit($config['subreddit'])
                ->sortBy($config['sort_by'] ?? 'hot')
                ->get();

            Tile::firstOrCreateForName("reddit_{$key}")->putData('things', $things);
        }
    }
}
