<?php

namespace Pixiv\Entity\Request;

use TurmericSpice\ReadWriteAttributes;

class SearchRequest
{
     use ReadWriteAttributes {
          mustHaveAsString  as public getQ;
          mustHaveAsString  as public getMode;
          mustHaveAsInt     as public getPerPage;
          mustHaveAsString  as public getOrder;
          mustHaveAsString  as public getSort;
          mustHaveAsBoolean as public getIncludeStats;
          mustHaveAsBoolean as public getIncludeSanityLevel;
          mustHaveAsString  as public getImageSizes;
          mustHaveAsString  as public getProfileImageSizes;
          setValue          as public setQ;
          setValue          as public setMode;
          setValue          as public setPerPage;
          setValue          as public setOrder;
          setValue          as public setSort;
          setValue          as public setIncludeStats;
          setValue          as public setIncludeSanityLevel;
          setValue          as public setImageSizes;
          setValue          as public setProfileImageSizes;
          __construct       as public turmericConstruct;
     }

     public function __construct($attributes = [])
     {
          $attributes += [
              'mode'                 => 'tag',
              'per_page'             => 30,
              'order'                => 'desc',
              'sort'                 => 'date',
              'include_stats'        => true,
              'include_sanity_level' => true,
              'image_sizes'          => 'px_128x128,px_480mw,large',
              'profile_image_sizes'  => 'px_170x170,px_50x50',
          ];
          $this->turmericConstruct($attributes);
     }
}
