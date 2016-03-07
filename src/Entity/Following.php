<?php

namespace Pixiv\Entity;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class Following extends Entity
{
    use ReadableAttributes {
        mayHaveAsString as public getStatus;
        mayHaveAsInt    as public getCount;
        mayHaveAsArray  as public getPagination;
    }

    /**
     * @return \Pixiv\Entity\Following\FollowingResponse[]
     */
    public function getResponse()
    {
        return $this->attributes->mayHave('response')
            ->asInstanceArray('Pixiv\\Entity\\Following\\FollowingResponse');
    }
}

