<?php
namespace Pixiv\Entity;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;

class Auth extends Entity
{
    use ReadableAttributes {
        mayHaveAsString as public getAccessToken;
        mayHaveAsInt    as public getExpiresIn;
        mayHaveAsString as public getTokenType;
        mayHaveAsString as public getScope;
        mayHaveAsString as public getRefreshToken;
        mayHaveAsString as public getDeviceToken;
        toArray         as public __toArray;
    }

    /**
     * @return \Pixiv\Entity\Auth\User|null
     */
    public function getUser()
    {
        return $this->attributes->mayHave('user')
            ->asInstanceOf('Pixiv\\Entity\\Auth\\User');
    }

    public function toArray()
    {
        $arr = $this->__toArray();
        $arr['user'] = $this->getUser()->toArray();

        return $arr;
    }
}
