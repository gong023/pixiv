<?php

namespace Pixiv;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRankingAll()
    {
        $client = new Client();

        $response = $client->getRankingAll();

        $this->assertInternalType('array', $response);
    }
}
