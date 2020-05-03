<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid grid-rows-auto-1">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }}
                <small class="text-xs text-dimmed font-light">Sorting by: {{ $sort }} </small>
            </h1>
        @endisset
        @if($things && count($things) > 0)
            <ul class="divide-y-2 -my-2">
                @foreach($things as $thing)
                    <li class="overflow-hidden py-4">
                        <div class="grid gap-2">
                            <div class="grid grid-cols-auto-1 gap-2 items-center">
                                <div class="overflow-hidden w-12 h-12 rounded relative" style="display: flex; justify-content: center; align-items: center; background-color: lightgray;">
                                    @if ($thing['image'] == \Dustycode\RedditTile\RedditParser::PAPER_ICON)
                                        <div class="w-6 h-6" style="color: lightgray">
                                            <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.5 3H9.003A2.005 2.005 0 007 5.007v22.986A2 2 0 008.997 30h15.006A1.999 1.999 0 0026 28.01V10l-6-7h-.5zM19 4H8.996C8.446 4 8 4.455 8 4.995v23.01c0 .55.455.995 1 .995h15c.552 0 1-.445 1-.993V11h-4.002A1.995 1.995 0 0119 8.994V4zm1 .5v4.491c0 .557.45 1.009.997 1.009H24.7L20 4.5zM10 10v1h5v-1h-5zm0-3v1h7V7h-7zm0 6v1h13v-1H10zm0 3v1h10v-1H10zm0 3v1h13v-1H10zm0 3v1h9v-1h-9zm0 3v1h13v-1H10z" fill="#000" fill-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @elseif ($thing['image'] == \Dustycode\RedditTile\RedditParser::WEB_ICON)
                                        <div class="w-6 h-6" style="color: lightgray">
                                            <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 11v15.001c0 .56.451.999 1.007.999H21v-4.994c0-1.12.894-2.006 1.998-2.006H27v-9H6zm0-1V6.999C6 6.447 6.439 6 6.999 6H26c.552 0 .999.45.999 1.007V10H6zm15.5 18H7c-1.105 0-2-.902-2-2V7c0-1.104.902-2 2-2h19c1.104 0 2 .895 2 1.994V21l-6 7h-.5zm.5-1.5v-4.491c0-.557.45-1.009.997-1.009H26.7L22 26.5z" fill="#000" fill-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @else
                                        <img
                                            src="{{ $thing['image'] }}"
                                            class="block w-12 h-12 object-cover"
                                        />
                                    @endif

                                </div>
                                <div class="leading-tight min-w-0">
                                    <div class="text-sm">
                                        {!! $thing['title'] !!}
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-dimmed">
                                <ul class="flex">
                                    <li class="mr-2 truncate" style="max-width: 7rem;">
                                        u/{{  $thing['author'] }}
                                    </li>
                                    <li class="mr-2">
                                        {{  \Dustycode\RedditTile\RedditParser::postedAtForHumans($thing['posted_at']) }}
                                    </li>
                                    <li class="mr-2">
                                        {{ $thing['score'] }} votes
                                    </li>
                                    <li>
                                        {{ $thing['comments'] }} comments
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="flex justify-center text-xs gray">
                Sorry, no reddit data have been found
            </div>
        @endif
    </div>
</x-dashboard-tile>
