<?php

namespace Pixiv\Retry;

class Retry
{
    public function __construct()
    {
        $this->container = new Container();
    }

    public function beforeOnce(callable $fn)
    {
        $this->container->set('beforeOnce', $fn);

        return $this;
    }

    public function beforeEach(callable $fn)
    {
        $this->container->set('beforeEach', $fn);

        return $this;
    }

    public function afterOnce(callable $fn)
    {
        $this->container->set('afterOnce', $fn);

        return $this;
    }

    public function afterEach(callable $fn)
    {
        $this->container->set('afterEach', $fn);

        return $this;
    }

    public function retry($times, callable $fn)
    {
        return $this->container->execute($times, $fn);
    }
}
