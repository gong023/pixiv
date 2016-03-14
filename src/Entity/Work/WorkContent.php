<?php

namespace Pixiv\Entity\Work;

use Pixiv\Entity;
use TurmericSpice\Container;
use TurmericSpice\ReadableAttributes;

class WorkContent extends Entity
{
    use ReadableAttributes {
        mayHaveAsInt     as public getInt;
        mayHaveAsString  as public getTitle;
        mayHaveAsString  as public getCaption;
        mayHaveAsArray   as public getTags;
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

    /**
     * @return \Datetime
     */
    public function getCreatedTime()
    {
        return $this->attributes->mayHave('created_time')->asInstanceOf('\\Datetime');
    }

    /**
     * @return \Datetime
     */
    public function getReuploadedTime()
    {
        return $this->attributes->mayHave('reuploaded_time')->asInstanceOf('\\Datetime');
    }

    /**
     * @return \Pixiv\Entity\User
     */
    public function getUser()
    {
        return $this->attributes->mayHave('user')->asInstanceOf('\\Pixiv\\Entity\\User');
    }

    /**
     * @return \Pixiv\Entity\ImageUrls
     */
    public function getImageUrls()
    {
        return $this->attributes->mayHave('image_urls')->asInstanceOf('\\Pixiv\\Entity\\ImageUrls');
    }

    /**
     * I don't need other things except 'pages' key which contains image_urls of manga.
     *
     * @return \Pixiv\Entity\ImageUrls[]
     */
    public function getMetadata()
    {
        $metadata = $this->attributes->mayHave('metadata')->asArray();
        if (isset($metadata['pages'])) {
            $imageUrls = [];
            foreach ($metadata['pages'] as $page) {
                $imageUrls[] = new Entity\ImageUrls($page['image_urls']);
            }

            return $imageUrls;
        }

        return [];
    }
}

