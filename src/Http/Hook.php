<?php

namespace Pixiv\Http;

use Pixiv\Http\Exception\ClientErrorException;
use TinyConfig\TinyConfig;

class Hook
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

        $trier->beforeOnce(function () {})
            ->beforeEach(function() {})
            ->retry(3, function() {})
            ->afterOnce(function() {})
            ->afterEach(function() {});
    }

    public function before()
    {
        TinyConfig::set('token', $this->auth->token()->getAccessToken());
    }

    public function getApi($domain)
    {
        $klass = 'Pixiv\\Http\\Domain\\' . $domain;
        $delegater = new Delegater(constant("{$klass}::BASE_URL"), [constant("{$klass}::REFERER")]);

        return new $klass($delegater);
    }
}
