<?php

namespace Pixiv\Entity\Auth;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class User extends Entity
{
    use ReadableAttributes {
        mayHaveAsArray  as public getProfileImageUrls;
        mayHaveAsString as public getId;
        mayHaveAsString as public getName;
        mayHaveAsString as public getAccount;
    }
}
