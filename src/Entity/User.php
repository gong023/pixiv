<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class User
{
    use ReadableAttributes {
        mayHaveAsInt     as public getId;
        mayHaveAsString  as public getAccount;
        mayHaveAsString  as public getName;
        mayHaveAsBoolean as public getIsFollowing;
        mayHaveAsBoolean as public getIsFollower;
        mayHaveAsBoolean as public getIsFriend;
        mayHaveAsArray   as public getProfileImageUrls;
    }

    public function getIsPremium()
    {
        return $this->attributes->mayHave('is_premium')->value();
    }

    public function getStats()
    {
        return $this->attributes->mayHave('stats')->value();
    }

    public function getProfile()
    {
        return $this->attributes->mayHave('profile')->value();
    }
}
