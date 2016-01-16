<?php

namespace Pixiv\Http\Domain;

use Pixiv\Entity\Following;
use Pixiv\Http\Delegator;
use TinyConfig\TinyConfig;

class PublicApi
{
    const BASE_URI = 'https://public-api.secure.pixiv.net/';
    const REFERER = 'http://spapi.pixiv-app.net/';

    /**
     * @var Delegator
     */
    private $delegetor;

    public function __construct(Delegator $delegator)
    {
        $this->delegetor = $delegator;
    }

    public function rankingAll(
        $page               = 1,
        $perPage            = 50,
        $mode               = 'daily',
        $includeStats       = 'true',
        $includeSanityLevel = 'true',
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $param = [
            'page'                 => $page,
            'per_page'             => $perPage,
            'mode'                 => $mode,
            'include_stats'        => $includeStats,
            'include_sanity_level' => $includeSanityLevel,
            'image_sizes'          => $imageSizes,
            'profile_image_sizes'  => $profileImageSizes,
        ];

        $contents = $this->delegetor->get('/v1/ranking/all/works.json', $param, [
            'headers' => [
                'Authorization' => 'Bearer ' . TinyConfig::get('token'),
            ]
        ])->getBody()->getContents();

        // now implementing
        return json_decode($contents, true);
    }

    public function following(
        $page               = 1,
        $perPage            = 30,
        $includeStats       = 'true',
        $includeSanityLevel = 'true',
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $params = [
            'include_sanity_level' => $includeSanityLevel,
            'profile_image_sizes'  => $profileImageSizes,
            'per_page'             => $perPage,
            'include_stats'        => $includeStats,
            'image_sizes'          => $imageSizes,
            'page'                 => $page,
        ];

        $contents = $this->delegetor->get('/v1/me/following/works.json', $params, [
            'headers' => [
                'Authorization' => 'Bearer ' . TinyConfig::get('token'),
            ]
        ])->getBody()->getContents();

        return new Following(json_decode($contents, true));
    }
}
