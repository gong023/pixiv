<?php

namespace Pixiv\Http\Domain;

use Pixiv\Http\Delegater;
use Pixiv\Entity\Auth as AuthEntity;
use TinyConfig\TinyConfig;

class Auth
{
    const BASE_URL = 'https://oauth.secure.pixiv.net';
    const REFERER = 'http://www.pixiv.net';

    private $delegater;

    public function __construct(Delegater $delegater)
    {
        $this->delegater = $delegater;
        $this->config = TinyConfig::get('initial_setting');
    }

    public function token()
    {
        $contents = $this->delegater->post('/auth/token', [
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'username'      => $this->config['username'],
            'password'      => $this->config['password'],
            'grant_type'    => $this->config['grant_type'],
            'device_token'  => $this->config['device_token'],
        ])->getBody()->getContents();

        $response = json_decode($contents, true)['response'];

        return new AuthEntity($response);
    }
}