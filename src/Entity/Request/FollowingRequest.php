<?php

namespace Pixiv\Entity\Request;

use TurmericSpice\ReadWriteAttributes;

class FollowingRequest
{
    use ReadWriteAttributes {
        mustHaveAsInt     as public getPage;
        mustHaveAsInt     as public getPerPage;
        mustHaveAsBoolean as public getIncludeStats;
        mustHaveAsBoolean as public getIncludeSanityLevel;
        mustHaveAsString  as public getImageSizes;
        mustHaveAsString  as public getProfileImageSizes;
        setValue          as public setPage;
        setValue          as public setPerPage;
        setValue          as public setIncludeStats;
        setValue          as public setIncludeSanityLevel;
        setValue          as public setImageSizes;
        setValue          as public setProfileImageSizes;
        __construct       as public turmericConstruct;
    }

    public function __construct($attributes = [])
    {
        $attributes += [
            'page'                 => 1,
            'per_page'             => 30,
            'include_stats'        => true,
            'include_sanity_level' => true,
            'image_sizes'          => 'px_128x128,px_480mw,large',
            'profile_image_sizes'  => 'px_170x170,px_50x50',
        ];
        $this->turmericConstruct($attributes);
    }
}
