<?php

namespace Pixiv\Retry;

class TestException extends \Exception {}

class RetryTest extends \PHPUnit_Framework_TestCase
{
    public function testRetry()
    {
        $retry = new Retry();

        $ret = $retry
            ->beforeEach(function() {})
            ->beforeOnce(function() {})
            ->afterEach(function() {})
            ->afterOnce(function() {})
            ->retry(3, function() { return 1; });

        $this->assertSame(1, $ret);
    }

    /**
     * @expectedException \Pixiv\Retry\TestException
     */
    public function testRetryFails()
    {
        $retry = new Retry();

        $retry
            ->beforeEach(function() {})
            ->beforeOnce(function() {})
            ->afterEach(function() {})
            ->afterOnce(function() {})
            ->retry(3, function() { throw new TestException; });
    }
}
