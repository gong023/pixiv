<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class Ranking
{
    use ReadableAttributes {
        mayHaveAsString as public getContent;
        mayHaveAsString as public getMode;
    }

    public function getDate()
    {
        $this->attributes->mayHave('date')->asInstanceOf('\\Datetime');
    }

    public function getWorks()
    {
        $this->attributes->mayHave('works')
            ->asInstanceArray('\\Pixiv\\Entity\\Ranking\\Work');
    }
}

