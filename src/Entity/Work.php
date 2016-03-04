<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class Work
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
