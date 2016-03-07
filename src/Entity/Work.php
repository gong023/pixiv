<?php

namespace Pixiv\Entity;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class Work extends Entity
{
    use ReadableAttributes {
        mayHaveAsInt as public getRank;
        mayHaveAsInt as public getPreviousRank;
    }

    public function getWorkContent()
    {
        $this->attributes->mayHave('work')
            ->asInstanceOf('\\Pixiv\\Entity\\Work\\WorkContent');
    }
}
