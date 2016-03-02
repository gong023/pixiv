<?php

namespace Pixiv\Http;

use GuzzleHttp\Client;
use Pixiv\Http\Exception\ServerErrorException;
use Pixiv\Http\Exception\UnknownErrorException;
use Pixiv\Http\Exception\ClientErrorException;
use GuzzleHttp\Exception\ClientException as OriginClientException;
use GuzzleHttp\Exception\ServerException as OriginServerException;

class Delegator
{
    public function __construct($baseUri, $options = [])
    {
        $options = array_merge($options, [
            'headers' => [
                'User-Agent'      => 'PixivIOSApp/5.8.7',
                'Accept-Language' => 'ja-JP',
            ],
        ]);
        $this->client = new Client([
            'base_uri' => $baseUri,
            $options,
        ]);
    }

    public function post($path, $parameter = [], $options = [])
    {
        $options = array_merge(['form_params' => $parameter], $options);

        return $this->sendWithCheck('POST', $path, $options);
    }

    public function get($path, $parameter = [], $options = [])
    {
        $parameter = urlencode(http_build_query($parameter));

        return $this->sendWithCheck('GET', "{$path}?{$parameter}", $options);
    }

    private function sendWithCheck($method, $uri, $options)
    {
        try {
            return $this->client->request($method, $uri, $options);
        } catch (OriginClientException $e) {
            throw new ClientErrorException($e->getMessage());
        } catch (OriginServerException $e) {
            throw new ServerErrorException($e->getMessage());
        } catch (\Exception $e) {
            throw new UnknownErrorException($e->getMessage());
        }
    }
}
