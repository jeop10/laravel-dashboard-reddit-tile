<?php

namespace Dustycode\RedditTile;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Str;

class RedditParser {

    const PAPER_ICON = 'paper_icon';
    const WEB_ICON = 'web_icon';

    private $list;

    private $posts = [];

    /**
     * RedditParser constructor.
     * @param $list
     */
    public function __construct($list)
    {
        $this->list = $list;
    }

    public static function make($list)
    {
        return new static($list);
    }

    public function parse()
    {
        $this->list = json_decode($this->list);
        return $this->getThings();
    }

    private function getThings()
    {
        if (isset($this->list->data)) {
            $things = $this->list->data->children;

            //make sure we have things!
            if (count($things) > 0) {
                //get the name of the things
                $thingsNames = [];
                foreach ($things as $thing) {
                    $data = $thing->data;
                    $thingsNames[] = $data->name;

                    $this->posts[] = [
                        'author' => $data->author,
                        'image' => $this->checkThumbNails($data),
                        'title' => $data->title,
                        'score' => $this->convertNumber($data->score),
                        'comments' => $this->convertNumber($data->num_comments),
                        'posted_at' => $data->created_utc,
                        'test' => $this->postedAtForHumans($data->created_utc),
                    ];
                }
            }
        }

        return $this->posts;
    }

    private function convertNumber($number, $precision = 2, $divisors = null)
    {
        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'k', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        $result = $number / $divisor;
        return number_format($result, $precision) + 0 . $shorthand;
    }

    public static function postedAtForHumans($created_utc)
    {
        $carbon = Carbon::createFromTimestampUTC($created_utc);
        $configTimezone = config("dashboard.tiles.reddit.general.timezone");
        return Redditparser::dateForHumans($carbon, $configTimezone);
    }

    /**
     * To make the for human version more small
     * @param Carbon $carbon
     * @return mixed
     */
    private static function dateForHumans(Carbon $carbon, $timezone = 'Europe/Madrid', $extraSmall = false)
    {
        $carbon->setTimezone(new DateTimeZone($timezone));
        $date = $carbon->diffForHumans(null, true);

        if ($extraSmall) {
            $date = str_replace([' seconds', ' second'], 'sec', $date);
            $date = str_replace([' minutes', ' minute'], 'min', $date);
            $date = str_replace([' hours', ' hour'], 'h', $date);
            $date = str_replace([' days', ' day'], 'd', $date);
            $date = str_replace([' weeks', ' week'], 'w', $date);
            $date = str_replace([' months', ' month'], 'm', $date);
        }

        return $date;
    }

    private function checkThumbNails($item)
    {
        $thumbnail = $item->thumbnail;

        if (Str::contains($thumbnail, ['http'])) {
            return $thumbnail;
        } elseif ($thumbnail == 'image' && Str::contains($item->url, ['redd'])) {
            return $item->url;
        } elseif($item->is_self) {
            return self::PAPER_ICON;
        } else {
            return self::WEB_ICON;
        }
    }

}
