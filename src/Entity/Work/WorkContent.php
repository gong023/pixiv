<?php

namespace Pixiv\Entity\Work;

use TurmericSpice\ReadableAttributes;

class WorkContent
{
    use ReadableAttributes {
        mayHaveAsInt     as public getInt;
        mayHaveAsString  as public getTitle;
        mayHaveAsString  as public getCaption;
        mayHaveAsArray   as public getTags;
        mayHaveAsArray   as public getImageUrls;
        mayHaveAsInt     as public getWidth;
        mayHaveAsInt     as public getHeight;
        mayHaveAsArray   as public getStats;
        mayHaveAsInt     as public getPublicity;
        mayHaveAsString  as public getAgeLimit;
        mayHaveAsBoolean as public getIsManga;
        mayHaveAsBoolean as public getIsLiked;
        mayHaveAsInt     as public getPageCount;
        mayHaveAsString  as public getBookStyle;
        mayHaveAsString  as public getType;
        mayHaveAsString  as public getSanityLevel;
        mayHaveAsArray   as public getMetadata;
    }

    public function getTools()
    {
        return $this->attributes->mayHave('tools')->value();
    }

    public function getFavoriteId()
    {
        return $this->attributes->mayHave('favorite_id')->value();
    }

    public function getContentType()
    {
        return $this->attributes->mayHave('content_type')->value();
    }

    public function getCreatedTime()
    {
        return $this->attributes->mayHave('created_time')->asInstanceOf('\\Datetime');
    }

    public function getReuploadedTime()
    {
        return $this->attributes->mayHave('reuploaded_time')->asInstanceOf('\\Datetime');
    }

    public function getUser()
    {
        return $this->attributes->mayHave('user')->asInstanceOf('\\Pixiv\\Entity\\User');
    }
}

