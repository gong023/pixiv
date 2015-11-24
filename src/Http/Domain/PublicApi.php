<?php

namespace Pixiv\Http\Domain;

use Pixiv\Http\Delegater;

class PublicApi
{
    const BASE_URI = 'https://public-api.secure.pixiv.net/v1';
    const REFERER = 'http://spapi.pixiv-app.net/';

    public function __construct(Delegater $delegater)
    {
        $this->delegeter = $delegater;
    }

    public function rankingAll(
        $page               = 1,
        $perPage            = 50,
        $mode               = 'male',
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

        $contents = $this->delegeter->get('/ranking/all', $param)->getBody()->getContents();

        return json_decode($contents, true);
    }
}
