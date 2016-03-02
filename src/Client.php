<?php

namespace Pixiv;

use Pixiv\Http\Delegator;
use Pixiv\Http\Domain\IPixiv;
use Retry\Retry;
use TinyConfig\TinyConfig;

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
        $this->ipixiv = new IPixiv(new Delegator('', IPixiv::REFERER));

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

    public function getRankingAll(
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

        return $this->retryWithToken(3, function() use ($param) {
            return $this->publicApi->rankingAll($param);
        });
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param string $includeStats
     * @param string $includeSanityLevel
     * @param string $imageSizes
     * @param string $profileImageSizes
     * @return Entity\Following
     */
    public function getFollowing(
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

        return $this->retryWithToken(3, function() use ($params) {
            return $this->publicApi->following($params);
        });
    }

    public function getImage($url)
    {
        return $this->ipixiv->getImage($url);
    }

    private function getApi($domain)
    {
        $klass = 'Pixiv\\Http\\Domain\\' . $domain;
        $delegator = new Delegator(constant("{$klass}::BASE_URI"), constant("{$klass}::REFERER"));

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

