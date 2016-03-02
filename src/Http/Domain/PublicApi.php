<?php

namespace Pixiv\Http\Domain;

use Pixiv\Entity\Following;
use Pixiv\Entity\Ranking;
use Pixiv\Http\Delegator;
use TinyConfig\TinyConfig;

class PublicApi
{
    const BASE_URI = 'https://public-api.secure.pixiv.net/';
    const REFERER = 'http://spapi.pixiv-app.net/';

    /**
     * @var Delegator
     */
    private $delegator;

    public function __construct(Delegator $delegator)
    {
        $this->delegator = $delegator;
    }

    public function rankingAll($param) {
        $contents = $this->delegator->get('/v1/ranking/all', $param, [
            'Connection'       => 'keep-alive',
            'Proxy-Connection' => 'keep-alive',
            'Accept'           => '*/*',
            'Accept-Encoding'  => 'gzip, deflate',
            'Authorization'    => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();

        return new Ranking(json_decode($contents, true));
    }

    public function following($params) {
        $contents = $this->delegator->get('/v1/me/following/works.json', $params, [
            'Authorization' => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();

        return new Following(json_decode($contents, true));
    }
}
