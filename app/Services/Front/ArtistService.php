<?php

namespace App\Services\Front;

use App\Constants\ParamsConstant;
use App\Helpers\YoutubeHelper;
use App\Models\Artist;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ArtistService
{

    /**
     * @return array
     */
    public function getLimitedArtists(): array
    {
        $artists = Artist::query()->limit(ParamsConstant::MAX_RESULTS['LIMITED_ARTISTS_LIST'])->get();
        return [
            "success" => true,
            "message" => "populyar ifaçılar",
            "data" => empty($artists) ? [] : $artists
        ];
    }

    /**
     * @return array
     */
    public function getAllArtists(): array
    {
        $artists = Artist::query()->paginate(ParamsConstant::MAX_RESULTS['ALL_ARTISTS_LIST']);
        return [
            "success" => true,
            "message" => "populyar ifaçılar",
            "data" => empty($artists) ? [] : $artists
        ];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getArtistDetails(array $data): mixed
    {
        $cacheKey = 'artist_details_' . md5($data['artist_slug'] . (isset($data['token']) ? '_' . $data['token'] : ''));
        return Cache::remember($cacheKey, config('app.cache_seconds'), function () use ($data) {
            $artist = Artist::query()->where("slug", $data['artist_slug'])->first();
            $data['query'] = $artist->name;
            return [
                "artist" => $artist,
                "musics" => (new MusicService())->getSearchResults($data)
            ];
        });
    }



}