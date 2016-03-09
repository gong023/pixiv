<?php

namespace Pixiv\Entity;

use Pixiv\Entity;
use Pixiv\Entity\Following\FollowingResponse;
use TurmericSpice\ReadableAttributes;

class Following extends Entity
{
    use ReadableAttributes {
        mayHaveAsString as public getStatus;
        mayHaveAsInt    as public getCount;
        mayHaveAsArray  as public getPagination;
    }

    /**
     * @return FollowingResponse[]
     */
    public function getResponse()
    {
        return $this->attributes->mayHave('response')
            ->asInstanceArray('Pixiv\\Entity\\Following\\FollowingResponse');
    }

    public function getWorkIds()
    {
        return array_map(function (FollowingResponse $followingResponse) {
            return $followingResponse->getId();
        }, $this->getResponse());
    }

    /**
     * @param Following $target
     * @return FollowingResponse[]
     */
    public function getResponseDiff(Following $target)
    {
        $targetIds = $target->getWorkIds();

        return array_filter($this->getResponse(), function (FollowingResponse $subject) use ($targetIds) {
            return ! in_array($subject->getId(), $targetIds);
        });
    }
}

