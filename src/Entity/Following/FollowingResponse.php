<?php

namespace Pixiv\Entity\Following;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class FollowingResponse extends Entity
{
    use ReadableAttributes {
        mayHaveAsInt     as public getId;
        mayHaveAsString  as public getTitle;
        mayHaveAsString  as public getCaption;
        mayHaveAsArray   as public getTags;
        mayHaveAsArray   as public getTools;
        mayHaveAsInt     as public getWidth;
        mayHaveAsInt     as public getHeight;
        mayHaveAsInt     as public getPublicity;
        mayHaveAsString  as public getAgeLimit;
        mayHaveAsBoolean as public getIsManga;
        mayHaveAsBoolean as public getIsLiked;
        mayHaveAsInt     as public getFavoriteId;
        mayHaveAsInt     as public getPageCount;
        mayHaveAsString  as public getBookStyle;
        mayHaveAsString  as public getType;
    }

    public function getStats()
    {
        return $this->attributes->mayHave('stats')->value();
    }

    /**
     * @return \Datetime
     */
    public function getCreatedTime()
    {
        return $this->attributes->mayHave('created_time')->asInstanceOf('\\DateTime');
    }

    /**
     * @return \Datetime
     */
    public function getReuploadedTime()
    {
        return $this->attributes->mayHave('reuploaded_time')->asInstanceOf('\\DateTime');
    }

    /**
     * @return \Pixiv\Entity\User
     */
    public function getUser()
    {
        return $this->attributes->mayHave('user')->asInstanceOf('\\Pixiv\\Entity\\User');
    }

    public function getMetadata()
    {
        return $this->attributes->mayHave('metadata')->value();
    }

    public function getContentType()
    {
        return $this->attributes->mayHave('content_type')->value();
    }

    /**
     * @return \Pixiv\Entity\ImageUrls
     */
    public function getImageUrls()
    {
        return $this->attributes->mayHave('image_urls')->asInstanceOf('\\Pixiv\\Entity\\ImageUrls');
    }
}
