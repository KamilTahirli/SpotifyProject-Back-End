<?php

namespace App\Services\Front;

use App\Constants\ParamsConstant;
use App\Dto\MusicDto;
use App\Helpers\YoutubeHelper;
use App\Models\MusicHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MusicService
{

    /**
     * @param string $musicId
     * @return array
     * @throws Exception
     */
    public function getConvertedMp3Url(string $musicId): array
    {
        $convertApiUrl = config('app.convert_music_api') . '/' . $musicId . '.mp3';

        $response = Http::withHeaders([
            'Referer' => $convertApiUrl
        ])
            ->withoutRedirecting()
            ->get($convertApiUrl);

        if (!$response->found()) {
            throw new Exception($response->body());
        }

        return $this->saveMusicToPath($response->header('Location'));
    }


    /**
     * @param string $downloadUrl
     * @return array
     * @throws Exception
     */
    public function saveMusicToPath(string $downloadUrl): array
    {
        $response = Http::timeout(1200)
            ->get($downloadUrl);
        if (!$response->ok()) {
            Log::error(__('messages.response.errors.get_music_download_url_request_failed') . $response->body());
            throw new Exception($response->body());
        }

        preg_match('/filename="([^"]+)"/', $response->headers()['Content-Disposition'][0] ?? "", $musicName);

        if (!$musicName) {
            preg_match('/filename=([^"]+)/', $response->headers()['Content-Disposition'][0] ?? "", $musicName);
        }

        $musicNameSlug = Str::slug(str_replace('.mp3', '', $musicName[1])) . '.mp3';
        $musicUrl = 'uploads/musics/' . $musicNameSlug;
        $targetPath = public_path($musicUrl);
        File::put($targetPath, $response->getBody());

        return [
            'music_name' => $musicNameSlug,
            'download_url' => url($musicUrl)
        ];

    }

    /**
     * @return array
     */
    public function getTrendMusicsForYt(): array
    {
        return Cache::remember('trends', config('app.cache_seconds'), function () {
            $params = ParamsConstant::TREND_MUSICS;

            $searchResults = Http::timeout(1200)->acceptJson()->post(config('app.youtube_search_api'), $params);

            $contents = $searchResults->json()['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'];
            $nextPageToken = $contents[1]['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'] ?? null;

            $parseSearchResult = $contents[0]['itemSectionRenderer']['contents'];

            $results = [];

            foreach ($parseSearchResult as $searchResult) {
                foreach ($searchResult as $list) {
                    if (isset($list['videoId'])) {
                        $response = [
                            'videoId' => $list['videoId'],
                            'thumbnail' => $list['thumbnail']['thumbnails'][0]['url'],
                            'title' => $list['title']['runs'][0]['text'],
                            'slug' => Str::slug($list['title']['runs'][0]['text']) . '-id-' . $list['videoId'],
                        ];
                        if (isset($list['lengthText']['simpleText'])) {
                            $response['duration'] = $list['lengthText']['simpleText'];
                            $excludeVideo = explode(':', $response['duration'])[0];

                            if (strlen($excludeVideo) >= 2 && $excludeVideo > 10 || substr_count($response['duration'], ":") > 1)
                                continue;

                        }
                        $results[] = $response;
                    }
                }
            }
            return [
                'results' => array_slice($results, 0, ParamsConstant::MAX_RESULTS['TREND']),
                'nextPageToken' => $nextPageToken
            ];
        });
    }

    /**
     * @param array $data
     * @return array
     */
    public function getSearchResults(array $data): mixed
    {
        $params = ParamsConstant::SEARCH_MUSIC;
        if (isset($data['token'])) {
            return YoutubeHelper::nextResult([
                "token" => $data['token'],
                "cacheKey" => "search_music_",
                "payload" => $params,
                "maxResults" => ParamsConstant::MAX_RESULTS['SEARCH_NEXT']
            ]);
        } else {
            $params['query'] = $data['query'];
            $response = Http::timeout(10000)->acceptJson()->post(config('app.youtube_search_api'), $params);
            $results = YoutubeHelper::parseYtResponseBody($response);

            if (count($results['contents']) < 10) {
                $newResult = YoutubeHelper::nextResult([
                    "token" => $results['nextPageToken'],
                    "cacheKey" => "search_music_",
                    "payload" => $params,
                    "maxResults" => ParamsConstant::MAX_RESULTS['SEARCH_NEXT']
                ]);
                $results['contents'] = array_merge($results['contents'], $newResult['results']);
                $results['nextPageToken'] = $newResult['nextPageToken'];
            }
            return [
                'results' => array_slice($results['contents'], 0, ParamsConstant::MAX_RESULTS['SEARCH']),
                'nextPageToken' => $results['nextPageToken'] ?? null
            ];
        }
    }


    /**
     * @param MusicDto $musicDto
     * @return array
     */
    public function getMusicData(MusicDto $musicDto): array
    {
        $musicData = MusicHistory::query()->where('music_id', '=', $musicDto->getMusicId())->first();
        return [
            "success" => true,
            "message" => empty($musicData) ? "Mahnı tapılmadı" : "Mahnı tapıldı",
            "data" => empty($musicData) ? [] : $musicData
        ];
    }


    /**
     * @param string $slug
     * @return array
     */
    public function getMusicDetail(string $slug): mixed
    {
        $parseSlug = explode('-id-', $slug);
        $videoId = array_pop($parseSlug);
        $cacheKey = md5($videoId);
        $cachedData = Cache::get($cacheKey);

        if ($cachedData && $cachedData['slug'] !== $slug) {
            abort(404);
        }
        return Cache::remember($cacheKey, config('app.cache_seconds'), function () use ($videoId, $slug) {

            $params = ParamsConstant::MUSIC_DETAIL;
            $params['videoId'] = $videoId;

            $searchResults = Http::acceptJson()->post(config('app.music_details_api'), $params)->json();
            $contents = $searchResults['contents']['twoColumnWatchNextResults']['results']['results']['contents'][0]['videoPrimaryInfoRenderer'] ?? [];
            $isLiveCheck = $contents['viewCount']['videoViewCountRenderer']['isLive'] ?? null;
            $isLive = !is_null($isLiveCheck) ? "true" : "false";
            if (!$contents) return [];
            $musicTitle = $contents['title']['runs'][0]['text'] ?? "";

            $videoId = $searchResults['contents']['twoColumnWatchNextResults']['results']['results']['contents'][1]['videoSecondaryInfoRenderer']['subscribeButton']['subscribeButtonRenderer']['signInEndpoint']['modalEndpoint']['modal']['modalWithTitleAndButtonRenderer']['button']['buttonRenderer']['navigationEndpoint']['signInEndpoint']['nextEndpoint']['watchEndpoint']['videoId'];
            $description = $searchResults['contents']['twoColumnWatchNextResults']['results']['results']['contents'][1]['videoSecondaryInfoRenderer']['attributedDescription']['content'] ?? "";

            $videoHashtags = $searchResults['contents']['twoColumnWatchNextResults']['results']['results']['contents'][1]['videoSecondaryInfoRenderer']['attributedDescription']['commandRuns'] ?? [];

            $responseSlug = Str::slug($musicTitle) . '-id-' . $videoId;

            if ($slug !== $responseSlug) {
                abort(404);
            }

            foreach ($videoHashtags as $hashtag) {
                $tags = $hashtag['onTap']['innertubeCommand'];
                foreach ($tags as $tag) {
                    if (isset($tag['webCommandMetadata']['url'])) {
                        $videoTags[] = str_replace('/hashtag/', '', $tag['webCommandMetadata']['url']);
                        break;
                    }
                }
            }

            $similarQuery = trim(explode('-', $musicTitle)[0]);

            return [
                "title" => $musicTitle,
                "thumbnail" => "https://i.ytimg.com/vi/${videoId}/hqdefault.jpg",
                "videoId" => $videoId,
                "description" => $description,
                "tags" => $videoTags ?? [],
                "isLive" => $isLive,
                "slug" => $responseSlug,
                "similarQuery" => $similarQuery ?? $musicTitle
            ];
        });
    }


    /**
     * @param string $musicName
     * @return array
     */
    public function getSimilarMusics(string $musicName): mixed
    {
        return Cache::remember(md5($musicName), config('app.cache_seconds'), function () use ($musicName) {
            $params = ParamsConstant::SEARCH_MUSIC;
            if (isset($data['token'])) {
                return $this->nextResult($data['token']);
            } else {
                $params['query'] = $musicName;

                $searchResults = Http::timeout(1200)->acceptJson()->post(config('app.youtube_search_api'), $params);

                $contents = $searchResults->json()['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'];
                $nextPageToken = $contents[1]['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'] ?? null;

                $parseSearchResult = $contents[0]['itemSectionRenderer']['contents'];

                $results = [];

                foreach ($parseSearchResult as $searchResult) {
                    foreach ($searchResult as $list) {
                        if (isset($list['videoId'])) {
                            $response = [
                                'videoId' => $list['videoId'],
                                'thumbnail' => $list['thumbnail']['thumbnails'][0]['url'],
                                'title' => $list['title']['runs'][0]['text'],
                                'slug' => Str::slug($list['title']['runs'][0]['text']) . '-id-' . $list['videoId'],
                            ];
                            if (isset($list['lengthText']['simpleText'])) {
                                $response['duration'] = $list['lengthText']['simpleText'];
                                $excludeVideo = explode(':', $response['duration'])[0];

                                if (strlen($excludeVideo) >= 2 && $excludeVideo > 10 || substr_count($response['duration'], ":") > 1)
                                    continue;

                            }
                            $results[] = $response;
                        }
                    }
                }
                return [
                    'results' => array_slice($results, 0, ParamsConstant::MAX_RESULTS['SIMILAR']),
                    'nextPageToken' => $nextPageToken
                ];
            }
        });
    }

    /**
     * @param MusicDto $musicDto
     * @return array
     */
    public function saveMusicToDb(MusicDto $musicDto): array
    {
        $music = MusicHistory::query()->create([
            'music_id' => $musicDto->getMusicId(),
            'music_name' => $musicDto->getMusicName(),
            'music_url' => $musicDto->getMusicUrl(),
            'created_at' => now()
        ]);

        if ($music)
            return [
                "success" => true,
                "message" => "Mahnı uğurla əlavə edildi",
                "data" => $music->music_url
            ];

        return ["success" => false];
    }

    /**
     * @return void
     */
    public function deleteExpiredMusics(): void
    {
        try {
            $expiredMusics = MusicHistory::query()->where('created_at', '<=', Carbon::now()->subDays(3))->get();
            foreach ($expiredMusics as $expiredMusic) {
                File::delete(public_path('uploads/musics/' . $expiredMusic->music_name));
                $expiredMusic->delete();
            }
        } catch (Exception $exception) {
            Log::error(__('messages.response.errors.delete_expired_musics_failed') . $exception->getMessage());
        }
    }
}