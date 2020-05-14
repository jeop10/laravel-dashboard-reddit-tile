# Reddit tile for [Laravel Dashboard](https://docs.spatie.be/laravel-dashboard).

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeop10/laravel-dashboard-reddit-tile.svg?style=flat-square)](https://packagist.org/packages/jeop10/laravel-dashboard-reddit-tile)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jeop10/laravel-dashboard-reddit-tile/run-tests?label=tests)](https://github.com/jeop10/laravel-dashboard-reddit-tile/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeop10/laravel-dashboard-reddit-tile.svg?style=flat-square)](https://packagist.org/packages/jeop10/laravel-dashboard-reddit-tile)

This tile can display a list of the post to your favorite subreddit. 

![img](docs/reddit-tile.jpg)

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard).

## Installation

You can install the package via composer:

```bash
composer require jeop10/laravel-dashboard-reddit-tile
```

## Usage

In the `dashboard` config file, you must add this configuration in the `tiles` key.
`````php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'reddit' => [
            'general' => [
                'useragent' => 'web:laravel-dashboard-reddit-tile:0.1',
                'timezone' => 'Your desired timezone', //Important to get the posted at
            ],
            'configurations' => [
                'default' => [
                    'subreddit' => 'aww',
                    'sort_by' => 'hot', // valid values are hot, new, rising, controversial, top
                    'refresh_interval_in_seconds' => 120,
                ],
                'covid' => [
                    'subreddit' => 'coronavirus',
                    'sort_by' => 'new',
                    'refresh_interval_in_seconds' => 60,
                ],
                //...
            ]
        ]   
    ]   
];
`````

In app\Console\Kernel.php you should schedule the `Dustycode\RedditTile\ListenForRedditPostsCommand` to run. You can let in run every minute if you want. You could also run is less frequently if you fast updates on the dashboard aren’t that important for this tile.

`````
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(Dustycode\RedditTile\ListenForRedditPostsCommand::class)->everyMinute();
}
`````

In your dashboard view you use the `livewire:reddit-tile` component.

```html
<x-dashboard>
    <livewire:reddit-tile position="a1:a4" configuration-name="default" title="r/Aww"/>
</x-dashboard>
```

The title attribute is optional


## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [All Contributors](../../contributors)
- File Icon by [Raj Dev](https://freeicons.io/profile/714) URL: [Link](https://freeicons.io/documents-icons-2/icon-document-text-icon-7477)
- Web Icon by [Raj Dev](https://freeicons.io/profile/714) URL: [Link](https://freeicons.io/documents-icons-2/icon-note-icon-7462#)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
