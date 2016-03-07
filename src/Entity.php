<?php

namespace Pixiv;

class Entity
{
    /**
     * @var \TurmericSpice\Container
     */
    public $attributes;

    /**
     * @return array|null
     */
    public function getRaw()
    {
        $this->attributes->getRaw();
    }
}

