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
        $this->ipixiv = new IPixiv(new Delegator('', [IPixiv::REFERER]));

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

    public function getRankingAll()
    {
        return $this->retryWithToken(3, function() {
            return $this->publicApi->rankingAll();
        });
    }

    /**
     * @return \Pixiv\Entity\Following
     */
    public function getFollowing()
    {
        return $this->retryWithToken(3, function() {
            return $this->publicApi->following();
        });
    }

    public function getImage($url)
    {
        return $this->ipixiv->getImage($url);
    }

    private function getApi($domain)
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

