<?php

namespace Pixiv\Entity\Request;

use Pixiv\Entity\Request;

/**
 * @method mixed getId
 * @method mixed getIncludeStats
 * @method mixed getIncludeSanityLevel
 * @method mixed getImageSizes
 * @method mixed getProfileImageSizes
 * @method $this setId($value)
 * @method $this setIncludeStats($value)
 * @method $this setIncludeSanityLevel($value)
 * @method $this setImageSizes($value)
 * @method $this setProfileImageSizes($value)
 */
class WorkRequest extends Request
{
    public $id;
    public $include_stats        = true;
    public $include_sanity_level = true;
    public $image_sizes          = 'px_128x128,px_480mw,large';
    public $profile_image_sizes  = 'px_170x170,px_50x50';
}
