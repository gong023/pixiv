<?php

namespace Pixiv\Http\Domain;

use Pixiv\Entity\Following;
use Pixiv\Entity\Ranking;
use Pixiv\Entity\Search;
use Pixiv\Entity\Work\WorkContent;
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

    public function rankingAll($param)
    {
        $contents = $this->delegator->get('/v1/ranking/all', $param, [
            'Proxy-Connection' => 'keep-alive',
            'Authorization'    => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();

        return new Ranking(json_decode($contents, true));
    }

    public function following($params)
    {
        $contents = $this->delegator->get('/v1/me/following/works.json', $params, [
            'Authorization' => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();

        return new Following(json_decode($contents, true));
    }

    public function work($id, $params)
    {
        $contents = $this->delegator->get("/v1/works/{$id}.json", $params, [
            'Proxy-Connection' => 'keep-alive',
            'Authorization'    => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();
        $r = json_decode($contents, true);
        $rawData = isset($r['response'][0]) ? $r['response'][0] : [];

        return new WorkContent($rawData);
    }

    public function search($params)
    {
        $contents = $this->delegator->get("/v1/search/works.json", $params, [
            'Proxy-Connection' => 'keep-alive',
            'Authorization'    => 'Bearer ' . TinyConfig::get('token'),
        ])->getBody()->getContents();

        return new Search(json_decode($contents, true));
    }
}
