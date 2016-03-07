<?php

namespace Pixiv;

class Entity
{
    /**
     * @var \TurmericSpice\Container
     */
    public $attributes;

    public function getRaw()
    {
        $this->attributes->getRaw();
    }
}

