<?php

namespace Pixiv;

use Pixiv\Http\Delegator;
use Pixiv\Http\Domain\IPixiv;
use Retry\Retry;
use TinyConfig\TinyConfig;
use Pixiv\Entity\Request;

class Client
{
    /**
     * @var \Pixiv\Http\Domain\Auth
     */
    private $auth;

    /**
     * @var \Pixiv\Http\Domain\PublicApi
     */
    private $publicApi;

    /**
     * @var \Pixiv\Http\Domain\IPixiv
     */
    private $ipixiv;

    public function __construct(
        $clientId, $clientSecret, $userName, $password, $deviceToken
    ) {
        $this->auth = $this->getApi('Auth');
        $this->publicApi = $this->getApi('PublicApi');
        $this->ipixiv = new IPixiv(new Delegator('', ['Referer' => IPixiv::REFERER]));

        TinyConfig::set('initial_setting', [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'username'      => $userName,
            'password'      => $password,
            'device_token'  => $deviceToken,
            'grant_type'    => 'password',
        ]);
    }

    public function getAccessToken()
    {
        return (new Retry())
            ->retry(3, function() {
                return $this->auth->token()->getAccessToken();
            });
    }

    /**
     * @param Request\RankingRequest $request
     * @return Entity\Ranking
     */
    public function getRankingAll(Request\RankingRequest $request = null)
    {
        if ($request === null) {
            $params = (new Request\RankingRequest())->toArray();
        } else {
            $params = $request->toArray();
        }

        return $this->retryWithToken(3, function() use ($params) {
            return $this->publicApi->rankingAll($params);
        });
    }

    /**
     * @param Request\WorkRequest $request
     * @return Entity\Work\WorkContent
     */
    public function getWork(Request\WorkRequest $request)
    {
        $id = $request->getId();
        $param = $request->toArray();

        return $this->retryWithToken(3, function() use ($id, $param) {
            return $this->publicApi->work($id, $param);
        });
    }

    /**
     * @param Request\FollowingRequest $request
     * @return Entity\Following
     */
    public function getFollowing(Request\FollowingRequest $request = null)
    {
        if ($request === null) {
            $params = (new Request\FollowingRequest())->toArray();
        } else {
            $params = $request->toArray();
        }

        return $this->retryWithToken(3, function() use ($params) {
            return $this->publicApi->following($params);
        });
    }

    /**
     * @param $url
     * @return Entity\Image
     */
    public function getImage($url)
    {
        return $this->ipixiv->getImage($url);
    }

    /**
     * @param Request\SearchRequest $request
     * @return Entity\Search
     */
    public function getSearchResult(Request\SearchRequest $request)
    {
        $params = $request->toArray();

        return $this->retryWithToken(3, function () use ($params) {
            return $this->publicApi->search($params);
        });
    }

    private function getApi($domain)
    {
        $klass = 'Pixiv\\Http\\Domain\\' . $domain;
        $delegator = new Delegator(constant("{$klass}::BASE_URI"), [
            'Referer' => constant("{$klass}::REFERER")
        ]);

        return new $klass($delegator);
    }

    private function retryWithToken($times, $proc)
    {
        return (new Retry())
            ->beforeEach(function() {
                TinyConfig::set('token', $this->getAccessToken());
            })
            ->retry($times, $proc);
    }
}

