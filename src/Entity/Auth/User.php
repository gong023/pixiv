<?php

namespace Pixiv\Entity\Auth;

use TurmericSpice\ReadableAttributes;

class User
{
    use ReadableAttributes {
        mayHaveAsArray  as public getProfileImageUrls;
        mayHaveAsString as public getId;
        mayHaveAsString as public getName;
        mayHaveAsString as public getAccount;
    }
}
