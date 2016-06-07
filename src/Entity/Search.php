<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class Search
{
    use ReadableAttributes {
        mayHaveAsString as public getStatus;
        mayHaveAsInt    as public getCount;
    }

    /**
     * @return \\Pixiv\\Entity\\Work\\WorkContent[]
     */
    public function getResponse()
    {
        return $this->attributes->mayHave('response')->asInstanceArray('\\Pixiv\\Entity\\Work\\WorkContent');
    }

    /**
     * @return \\Pixiv\\Entity\\Pagination
     */
    public function getPagination()
    {
        return $this->attributes->mayHave('pagination')->asInstanceOf('\\Pixiv\\Entity\\Pagination');
    }
}
