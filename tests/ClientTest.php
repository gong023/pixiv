<?php

namespace Pixiv;

/**
 * @property Client client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $config = require_once __DIR__ . '/Config.php';
        $this->client = new Client(
            $config['client_id'],
            $config['client_secret'],
            $config['user_name'],
            $config['password'],
            $config['device_token']
        );
    }

//    public function testGetRankingAll()
//    {
//        $response = $this->client->getRankingAll();
//
//        $this->assertTrue(true);
//    }

    public function testGetFollowing()
    {
        $response = $this->client->getFollowing();

        $this->assertInstanceOf('\\Pixiv\\Entity\\Following', $response);
        $this->assertInternalType('array', $response->toArray());
    }

    /**
     * @dataProvider imageUrlProvider
     * @param $imageUrl
     */
    public function testGetImage($imageUrl)
    {
        $response = $this->client->getImage($imageUrl);

        $this->assertInstanceOf('\\Pixiv\\Entity\\Image', $response);
        $this->assertNotEmpty($response->getByte());
    }

    public function imageUrlProvider()
    {
        return [
            ['http://i3.pixiv.net/c/128x128/img-master/img/2016/01/15/16/59/23/54725462_p3_square1200.jpg'],
            ['http://i4.pixiv.net/c/480x960/img-master/img/2016/03/02/07/05/18/55580639_p0_master1200.jpg'],
        ];
    }
}
