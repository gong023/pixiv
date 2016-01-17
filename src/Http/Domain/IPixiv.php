<?php

namespace Pixiv\Http\Domain;

use GuzzleHttp\Client;
use Pixiv\Http\Delegator;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;

class IPixiv
{
    const BASE_URI = 'http://i%s.pixiv.net/';
    const REFERER = 'http://www.pixiv.net';

    private $delegator;

    public function __construct(Delegator $delegator)
    {
        $this->delegator = $delegator;
    }

    public static function dl($url, $savePath)
    {
        $header = [
            'User-Agent'      => 'PixivIOSApp/5.8.3',
            'Accept-Language' => 'ja-JP',
            'Accept-Encoding' => 'gzip, deflate',
        ];
        $client = new Client();
        $request = new Request('get', $url, $header);
        $response = $client->send($request);

        $resource = fopen($savePath, 'w');
        /* @var $fileStream \GuzzleHttp\Psr7\Stream */
        $fileStream = Psr7\stream_for($resource);
        $fileStream->write($response->getBody()->getContents());
        fclose($response);

        return $response->getBody();
    }
}