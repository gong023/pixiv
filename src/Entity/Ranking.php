<?php

namespace Pixiv\Entity;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class Ranking extends Entity
{
    use ReadableAttributes {
        mayHaveAsString as public getContent;
        mayHaveAsString as public getMode;
    }

    /**
     * @return \Datetime
     */
    public function getDate()
    {
        $this->attributes->mayHave('date')->asInstanceOf('\\Datetime');
    }

    /**
     * @return \Pixiv\Entity\Work[]
     */
    public function getWorks()
    {
        $this->attributes->mayHave('works')->asInstanceArray('\\Pixiv\\Entity\\Work');
    }
}

