<?php

namespace Pixiv\Entity;

class Request
{
    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/\A(get|set)(.+)\z/', $name, $matches)) {
            $member = $this->underscore($matches[2]);
            switch ($matches[1]) {
                case 'set':
                    $this->{$member} = current($arguments);
                    return $this;
                case 'get':
                    return $this->{$member};
            }
        }

        throw new \RuntimeException($name . ' is not defined');
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    protected function underscore($str)
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z]+)/', '_\\1', $str));
    }

}
