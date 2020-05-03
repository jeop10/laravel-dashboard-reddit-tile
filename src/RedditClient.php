<?php

namespace Dustycode\RedditTile;

use Illuminate\Support\Facades\Http;

class RedditClient {

    private $subReddit;

    private $sortBy;

    private $testMode = false;

    public static function make()
    {
        return new static();
    }

    public function subReddit($name)
    {
       $this->subReddit = $name;
       return $this;
    }

    public function sortBy($sort)
    {
        $this->sortBy = $sort;
        return $this;
    }

    public function get()
    {

        $url = "https://www.reddit.com/r/{$this->subReddit}/{$this->sortBy}.json?limit=10";

        if ($this->testMode) {
            $results = json_decode(file_get_contents(__DIR__ . "/resources/stubs/subreddit.json"));
        } else {
            $results = Http::withHeaders([
                'User-Agent'     => 'web:laravel-dashboard-reddit-tile:0.1',
            ])
                ->get($url)
                ->body();
        }

        if ($results) {
            //List parsed?
            return RedditParser::make($results)
                ->parse();
        }

        return [];
    }



}
