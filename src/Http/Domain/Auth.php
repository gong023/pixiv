<?php

namespace Pixiv\Http\Domain;

use Pixiv\Http\Delegater;
use Pixiv\Entity\Auth as AuthEntity;

class Auth
{
    const BASE_URL = 'https://oauth.secure.pixiv.net';

    private $delegater;

    public function __construct()
    {
        $this->delegater = new Delegater(static::BASE_URL, [
            'Referer' => 'http://www.pixiv.net',
        ]);
        $config = require __DIR__ . '/../../Config.php';
        $this->config = $config['auth_token'];
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