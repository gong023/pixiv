<?php

namespace Pixiv\Entity;

use Pixiv\Entity;
use TurmericSpice\ReadableAttributes;
use GuzzleHttp\Psr7;

class Image extends Entity
{
    use ReadableAttributes {
        mayHaveAsString as public getByte;
    }

    public function saveToFile($path)
    {
        $resource = fopen($path, 'w');
        /* @var $fileStream \GuzzleHttp\Psr7\Stream */
        $fileStream = Psr7\stream_for($resource);
        $fileStream->write($this->getByte());
        fclose($resource);
    }
}
