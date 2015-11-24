<?php

namespace Pixiv;

use Pixiv\Http\Delegater;
use TinyConfig\TinyConfig;
use TinyConfig\TinyConfigEmptyException;

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

    public function getRankingAll()
    {
        $this->publicApi->rankingAll();
    }

    public function getToken()
    {
        try {
            $token = TinyConfig::get('token');
        } catch (TinyConfigEmptyException $e) {
            $token = $this->auth->token()->getAccessToken();
            TinyConfig::set('token', $token);
        }

        return $token;
    }

    public function getApi($domain)
    {
        $klass = 'Pixiv\\Http\\Domain\\' . $domain;
        $delegater = new Delegater(constant("{$klass}::BASE_URL"), constant("{$klass}::REFERER"));

        return new $klass($delegater);
    }

    public function setPassword()
    {
        $initialSetting = require __DIR__ . '/Config.php';
        TinyConfig::set('initial_setting', $initialSetting['initial_setting']);
    }
}

