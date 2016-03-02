<?php

namespace Pixiv\Http\Domain;

use Pixiv\Entity\Image;
use Pixiv\Http\Delegator;

class IPixiv
{
    const BASE_URI = 'http://i%s.pixiv.net/';
    const REFERER = 'http://www.pixiv.net';

    private $delegator;

    public function __construct(Delegator $delegator)
    {
        $this->delegator = $delegator;
    }

    public function getImage($url)
    {
        $byte = $this->delegator->get($url, [], [
            'headers' => [
                'Connection'      => 'keep-alive',
                'Accept'          => '*/*',
                'Accept-Encoding' => 'gzip, deflate',
            ]
        ])->getBody()->getContents();

        return new Image(['byte' => $byte]);
    }
}
