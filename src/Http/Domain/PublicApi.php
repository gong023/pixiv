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

    public function rankingAll($param) {
        $contents = $this->delegetor->get('/v1/ranking/all', $param, [
            'headers' => [
                'Authorization' => 'Bearer ' . TinyConfig::get('token'),
            ]
        ])->getBody()->getContents();

        // now implementing
        return json_decode($contents, true);
    }

    public function following($params) {
        $contents = $this->delegetor->get('/v1/me/following/works.json', $params, [
            'headers' => [
                'Authorization' => 'Bearer ' . TinyConfig::get('token'),
            ]
        ])->getBody()->getContents();

        return new Following(json_decode($contents, true));
    }
}
