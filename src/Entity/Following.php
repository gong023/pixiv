<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class Following
{
    use ReadableAttributes {
        mayHaveAsString as public getStatus;
        mayHaveAsInt    as public getCount;
        mayHaveAsArray  as public getPagination;
    }

    public function getResponse()
    {
        return $this->attributes->mayHave('response')
            ->asInstanceArray('Pixiv\\Entity\\Following\\FollowingResponse');
    }
}

