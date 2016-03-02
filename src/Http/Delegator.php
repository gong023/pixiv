<?php

namespace Pixiv\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Pixiv\Http\Exception\ServerErrorException;
use Pixiv\Http\Exception\UnknownErrorException;
use Pixiv\Http\Exception\ClientErrorException;
use GuzzleHttp\Exception\ClientException as OriginClientException;
use GuzzleHttp\Exception\ServerException as OriginServerException;

class Delegator
{
    private $defaultHeader;

    public function __construct($baseUri, $referer)
    {
        $this->defaultHeader = [
            'User-Agent'      => 'PixivIOSApp/5.8.7',
            'Accept-Language' => 'ja-JP',
            'Referer'         => $referer,
        ];
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    public function postForm($path, $form = [], $headers = ['Content-Type' => 'application/x-www-form-urlencoded'])
    {
        $headers = array_merge_recursive($headers, $this->defaultHeader);
        $form = http_build_query($form, null, '&');
        $request = new Request('POST', $path, $headers, $form);

        return $this->sendWithCheck($request);
    }

    public function get($path, $query = [], $headers = [])
    {
        $headers = array_merge_recursive($headers, $this->defaultHeader);
        $queryParameter = http_build_query($query);
        $request = new Request('GET', "{$path}?{$queryParameter}", $headers);

        return $this->sendWithCheck($request);
    }

    private function sendWithCheck(Request $request)
    {
        try {
            return $this->client->send($request);
        } catch (OriginClientException $e) {
            throw new ClientErrorException($e->getMessage());
        } catch (OriginServerException $e) {
            throw new ServerErrorException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnknownErrorException($e->getMessage());
        }
    }
}
