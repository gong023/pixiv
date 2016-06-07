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
        toArray         as public __toArray;
    }

    /**
     * @return FollowingResponse[]
     */
    public function getResponse()
    {
        return $this->attributes->mayHave('response')
            ->asInstanceArray('Pixiv\\Entity\\Following\\FollowingResponse');
    }

    public function getPagination()
    {
        return $this->attributes->mayHave('pagination')->asInstanceOf('\\Pixiv\\Entity\\Pagination');
    }

    public function toArray()
    {
        return [
            'status' => $this->getStatus(),
            'count'  => $this->getCount(),
            'pagination' => $this->getPagination(),
            'response'   => $this->getResponse(),
        ];
    }

    public function getWorkIds()
    {
        return array_map(function (FollowingResponse $followingResponse) {
            return $followingResponse->getId();
        }, $this->getResponse());
    }

    /**
     * @param $workId
     * @return FollowingResponse
     */
    public function getResponseById($workId)
    {
        foreach ($this->getResponse() as $response) {
            if ($response->getId() === (int)$workId) {
                return $response;
            }
        }

        throw new \LogicException($workId . ' is not found');
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

