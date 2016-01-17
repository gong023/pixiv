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

    public function testDl()
    {
        $this->client->downloadImage();
    }
}
