<?php

namespace Pixiv\Entity\Request;

use Pixiv\Entity\Request;

/**
 * @method mixed getQ
 * @method mixed getMode
 * @method mixed getPerPage
 * @method mixed getOrder
 * @method mixed getSort
 * @method mixed getIncludeStats
 * @method mixed getIncludeSanityLevel
 * @method mixed getImageSizes
 * @method mixed getProfileImageSizes
 * @method $this setQ($value)
 * @method $this setMode($value)
 * @method $this setPerPage($value)
 * @method $this setOrder($value)
 * @method $this setSort($value)
 * @method $this setIncludeStats($value)
 * @method $this setIncludeSanityLevel($value)
 * @method $this setImageSizes($value)
 * @method $this setProfileImageSizes($value)
 */
class SearchRequest extends Request
{
    public $q;
    public $mode                 = 'tag';
    public $per_page             = 30;
    public $order                = 'desc';
    public $sort                 = 'date';
    public $include_stats        = true;
    public $include_sanityLevel  = true;
    public $image_sizes          = 'px_128x128,px_480mw,large';
    public $profile_image_sizes  = 'px_170x170,px_50x50';
}
