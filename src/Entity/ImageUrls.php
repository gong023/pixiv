<?php

namespace Pixiv\Entity;

class ImageUrls
{
    /**
     * @var array
     */
    private $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
    }

    public function getByKey($key)
    {
        return $this->raw[$key];
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function getLastOne()
    {
        $last = end($this->raw);
        reset($this->raw);

        return $last;
    }
}
