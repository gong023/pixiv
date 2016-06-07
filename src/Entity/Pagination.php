<?php

namespace Pixiv\Entity;

use TurmericSpice\ReadableAttributes;

class Pagination
{
    use ReadableAttributes {
        mayHaveAsInt as public getNext;
        mayHaveAsInt as public getCurrent;
        mayHaveAsInt as public getPerPage;
        mayHaveAsInt as public getTotal;
        mayHaveAsInt as public getPages;
    }

    public function getPrevious()
    {
        return $this->attributes->mayHave('previous')->value();
    }
}
