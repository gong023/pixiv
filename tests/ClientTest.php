<?php

namespace Pixiv;

/**
 * @property Client client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Client();
    }

    public function testGetFollowing()
    {
        $response = $this->client->getFollowing();

        $this->assertInstanceOf('\\Pixiv\\Entity\\Following', $response);
        $this->assertInternalType('array', $response->toArray());
    }

    public function testGetImage()
    {
        $response = $this->client->getImage('http://i3.pixiv.net/c/128x128/img-master/img/2016/01/15/16/59/23/54725462_p3_square1200.jpg');

        $this->assertInstanceOf('\\Pixiv\\Entity\\Image', $response);
        $this->assertNotEmpty($response->getByte());
    }
}
