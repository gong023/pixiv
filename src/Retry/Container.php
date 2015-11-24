<?php

namespace Pixiv\Retry;

class Container
{
    private $procs = [];

    public function set($key, callable $fn)
    {
        $this->procs[$key] = $fn;
    }

    public function execute($times, callable $fn)
    {
        $this->callWithCheck('beforeOnce');
        for ($i = 1; $i <= $times; $i++) {
            $this->callWithCheck('beforeEach');
            try {
                $ret = $fn();
                $this->callWithCheck('afterEach', $ret);
                goto afterOnce;
            } catch (\Exception $e) {
                if ($i === $times) {
                    throw new $e;
                }
            }
        }
        afterOnce:
        /** @noinspection PhpUndefinedVariableInspection */
        $this->callWithCheck('afterOnce', $ret);
        $this->procs = [];

        return $ret;
    }

    private function callWithCheck($key, $arg = null)
    {
        if ($this->procs[$key]) {
            return $this->procs[$key]($arg);
        }
    }
}
