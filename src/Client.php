<?php

namespace Pixiv;

use Pixiv\Http\Delegator;
use Pixiv\Retry\Retry;
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

    public function __construct()
    {
        $this->auth = $this->getApi('Auth');
        $this->publicApi = $this->getApi('PublicApi');
    }

    public function getAccessToken()
    {
        return (new Retry())
            ->beforeOnce(function() {
                $initialSetting = require __DIR__ . '/Config.php';
                TinyConfig::set('initial_setting', $initialSetting['initial_setting']);
            })
            ->retry(1, function() { return $this->auth->token()->getAccessToken(); });
    }

    public function getRankingAll()
    {
        return $this->retryWithToken(1, function() { return $this->publicApi->rankingAll(); });
    }

    public function getFollowing()
    {
        return $this->retryWithToken(1, function() { return $this->publicApi->following(); });
    }

    public function getApi($domain)
    {
        $klass = 'Pixiv\\Http\\Domain\\' . $domain;
        $delegator = new Delegator(constant("{$klass}::BASE_URI"), [constant("{$klass}::REFERER")]);

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

