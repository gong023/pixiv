<?php

namespace Pixiv\Http\Domain;

use Pixiv\Http\Delegator;
use TinyConfig\TinyConfig;

class PublicApi
{
    const BASE_URI = 'https://public-api.secure.pixiv.net';
    const REFERER = 'http://spapi.pixiv-app.net/';

    public function __construct(Delegator $delegater)
    {
        $this->delegeter = $delegater;
    }

    public function rankingAll(
        $page               = 1,
        $perPage            = 50,
        $mode               = 'daily',
        $includeStats       = true,
        $includeSanityLevel = true,
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $param = [
            'page'                 => $page,
            'per_page'             => $perPage,
            'mode'                 => $mode,
            'include_stats'        => $includeStats,
            'include_sanity_level' => $includeSanityLevel,
            'image_sizes'          => urlencode($imageSizes),
            'profile_image_sizes'  => urlencode($profileImageSizes),
        ];

        $contents = $this->delegeter->get('/v1/ranking/all', $param, [
            'headers' => [
                'User-Agent'      => 'PixivIOSApp/5.8.3',
                'Accept-Language' => 'ja-JP',
                'Authorization' => 'Bearer ' . TinyConfig::get('token'),
            ]
        ])->getBody()->getContents();

        return json_decode($contents, true);
    }
}
