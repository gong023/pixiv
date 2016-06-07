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

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    public function __construct(
        $clientId, $clientSecret, $userName, $password, $deviceToken
    ) {
        $this->auth = $this->getApi('Auth');
        $this->publicApi = $this->getApi('PublicApi');
        $this->ipixiv = new IPixiv(new Delegator('', ['Referer' => IPixiv::REFERER]));

        $this->reflection = new \ReflectionClass(__CLASS__);

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
     * @param int $page
     * @param int $perPage
     * @param string $mode
     * @param string $includeStats
     * @param string $includeSanityLevel
     * @param string $imageSizes
     * @param string $profileImageSizes
     * @return \Pixiv\Entity\Ranking
     */
    public function getRankingAll(
        $page               = 1,
        $perPage            = 50,
        $mode               = 'daily',
        $includeStats       = 'true',
        $includeSanityLevel = 'true',
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $param = $this->migrateParameter(__FUNCTION__, func_get_args());

        return $this->retryWithToken(3, function() use ($param) {
            return $this->publicApi->rankingAll($param);
        });
    }

    /**
     * @param $id
     * @param bool|true $includeStats
     * @param bool|true $includeSanityLevel
     * @param string $imageSizes
     * @param string $profileImageSizes
     * @return \Pixiv\Entity\Work\WorkContent
     */
    public function getWork(
        $id,
        $includeStats       = true,
        $includeSanityLevel = true,
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $param = $this->migrateParameter(__FUNCTION__, func_get_args());

        return $this->retryWithToken(3, function() use ($id, $param) {
            return $this->publicApi->work($id, $param);
        });
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param bool $includeStats
     * @param bool $includeSanityLevel
     * @param string $imageSizes
     * @param string $profileImageSizes
     * @return Entity\Following
     */
    public function getFollowing(
        $page               = 1,
        $perPage            = 30,
        $includeStats       = true,
        $includeSanityLevel = true,
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $params = $this->migrateParameter(__FUNCTION__, func_get_args());

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
     * @param $q
     * @param string $mode
     * @param int $perPage
     * @param string $order
     * @param string $sort
     * @param bool $includeStats
     * @param bool $includeSanityLevel
     * @param string $imageSizes
     * @param string $profileImageSizes
     * @return Entity\Search
     */
    public function getSearchResult(
        $q,
        $mode               = 'tag',
        $perPage            = 30,
        $order              = 'desc',
        $sort               = 'date',
        $includeStats       = true,
        $includeSanityLevel = true,
        $imageSizes         = 'px_128x128,px_480mw,large',
        $profileImageSizes  = 'px_170x170,px_50x50'
    ) {
        $params = $this->migrateParameter(__FUNCTION__, func_get_args());

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

    /**
     * kuso
     *
     * @param $functionName
     * @param $funcGetArgs
     * @return array
     */
    private function migrateParameter($functionName, $funcGetArgs)
    {
        $migrated = [];
        foreach ($this->reflection->getMethod($functionName)->getParameters() as $index => $param) {
            if (isset($funcGetArgs[$index])) {
                $migrated[$param->name] = $funcGetArgs[$index];
            } else {
                $migrated[$param->name] = $param->getDefaultValue();
            }
        }
        
        return $migrated;
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

