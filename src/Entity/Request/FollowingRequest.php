<?php

namespace Pixiv\Entity\Request;

use Pixiv\Entity\Request;

/**
 * @method mixed getPage
 * @method mixed getPerPage
 * @method mixed getIncludeStats
 * @method mixed getIncludeSanityLevel
 * @method mixed getImageSizes
 * @method mixed getProfileImageSizes
 * @method $this setPage($value)
 * @method $this setPerPage($value)
 * @method $this setIncludeStats($value)
 * @method $this setIncludeSanityLevel($value)
 * @method $this setImageSizes($value)
 * @method $this setProfileImageSizes($value)
 */
class FollowingRequest extends Request
{
    public $page                 = 1;
    public $per_page             = 30;
    public $include_stats        = true;
    public $include_sanity_level = true;
    public $image_sizes          = 'px_128x128,px_480mw,large';
    public $profile_image_sizes  = 'px_170x170,px_50x50';
}
