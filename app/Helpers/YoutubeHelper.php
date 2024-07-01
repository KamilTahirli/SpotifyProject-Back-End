<?php

namespace App\Helpers;

use App\Constants\ParamsConstant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class YoutubeHelper
{
    public static function parseYtResponseBody($response)
    {
        $contents = $response->json()['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'];
        $nextPageToken = $contents[1]['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'] ?? null;

        $items = $contents[0]['itemSectionRenderer']['contents'];
        $results = [];
        foreach ($items as $item) {
            foreach ($item as $list) {

                if (isset($list['videoId']) && isset($list['lengthText']['simpleText'])) {
                    $response = [
                        'videoId' => $list['videoId'],
                        'thumbnail' => $list['thumbnail']['thumbnails'][0]['url'],
                        'title' => $list['title']['runs'][0]['text'],
                        'slug' => Str::slug($list['title']['runs'][0]['text']) . '-id-' . $list['videoId'],
                    ];

                    $response['duration'] = $list['lengthText']['simpleText'];
                    $excludeVideo = explode(':', $response['duration'])[0];
                    if (strlen($excludeVideo) >= 2 && $excludeVideo > 10 || substr_count($response['duration'], ":") > 1) {
                        continue;
                    }
                    $results[] = $response;
                }
            }
        }
        return [
            "contents" => $results,
            "nextPageToken" => $nextPageToken
        ];
    }


    public static function nextResult($config)
    {
        $cacheKey = $config['cacheKey'] . md5($config['token']);
        return Cache::remember($cacheKey, config('app.cache_seconds'), function () use ($config) {

            $params = $config['payload'];
            $params["continuation"] = $config['token'];
            $searchResults = Http::acceptJson()->post(config('app.youtube_search_api'), $params);

            $contents = $searchResults->json()['onResponseReceivedCommands'][0]['appendContinuationItemsAction']['continuationItems'][0]['itemSectionRenderer']['contents'];
            $nextPageToken = $searchResults->json()['onResponseReceivedCommands'][0]['appendContinuationItemsAction']['continuationItems'][1]['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'] ?? null;
            $results = [];

            foreach ($contents as $content) {
                $time = $content['videoRenderer']['lengthText']['simpleText'] ?? null;
                $excludeVideo = explode(':', $time)[0];

                if (strlen($excludeVideo) >= 2 && $excludeVideo > 10 || substr_count($time, ":") > 1) {
                    continue;
                } else {
                    if (isset($content['videoRenderer']['videoId']) && !is_null($time)) {
                        $response = [
                            'videoId' => $content['videoRenderer']['videoId'],
                            'thumbnail' => $content['videoRenderer']['thumbnail']['thumbnails'][0]['url'],
                            'title' => $content['videoRenderer']['title']['runs'][0]['text'],
                            'slug' => Str::slug($content['videoRenderer']['title']['runs'][0]['text']) . '-id-' . $content['videoRenderer']['videoId'],
                            'duration' => $time
                        ];

                        $results[] = $response;
                    }
                }
            }
            return [
                'results' => array_slice($results, 0, $config['maxResults']),
                'nextPageToken' => $nextPageToken
            ];
        });
    }


}