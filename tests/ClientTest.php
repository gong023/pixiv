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

    public function testGetRankingAll()
    {
        $response = $this->client->getFollowing();

        $this->assertInternalType('array', $response);
    }

    public function testGetFollowing()
    {
        $response = $this->client->getFollowing();

        $this->assertInternalType('array', $response);
    }
}
