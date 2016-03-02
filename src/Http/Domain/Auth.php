<?php

namespace Pixiv\Http\Domain;

use Pixiv\Http\Delegator;
use Pixiv\Entity\Auth as AuthEntity;
use TinyConfig\TinyConfig;

class Auth
{
    const BASE_URI = 'https://oauth.secure.pixiv.net';
    const REFERER = 'http://www.pixiv.net';

    private $delegator;

    public function __construct(Delegator $delegator)
    {
        $this->delegator = $delegator;
    }

    public function token()
    {
        $config = TinyConfig::get('initial_setting');
        $contents = $this->delegator->postForm('/auth/token', [
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'username'      => $config['username'],
            'password'      => $config['password'],
            'grant_type'    => $config['grant_type'],
            'device_token'  => $config['device_token'],
        ])->getBody()->getContents();

        $response = json_decode($contents, true)['response'];

        return new AuthEntity($response);
    }
}
