<?php

namespace Pixiv\Entity\Ranking;

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
            ->asInstanceOf('\\Pixiv\\Entity\\Ranking\\Work\\WorkContent');
    }
}
