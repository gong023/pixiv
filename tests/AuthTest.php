<?php

namespace Pixiv;

use Pixiv\Http\Domain\Auth;

/**
 * @property Auth auth
 */
class AuthTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->auth = new Auth();
    }

    public function testRequest()
    {
        $response = $this->auth->token();

        $this->assertInstanceOf('Pixiv\\Entity\\Auth', $response);
        $this->assertInstanceOf('Pixiv\\Entity\\Auth\\User', $response->getUser());
        $this->assertInternalType('array', $response->toArray());
    }
}
