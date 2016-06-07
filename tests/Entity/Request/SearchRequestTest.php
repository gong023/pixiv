<?php

namespace Pixiv\Entity\Request;

use AssertChain\AssertChain;

class SearchRequestTest extends \PHPUnit_Framework_TestCase
{
    use AssertChain;

    public function testAccessor()
    {
        $searchRequest = new SearchRequest();

        $this->assert()
            ->null($searchRequest->getQ())
            ->instanceOf('\\Pixiv\\Entity\\Request\\SearchRequest', $searchRequest->setQ('query'))
            ->same('query', $searchRequest->getQ());
    }

    /**
     * @dataProvider paramProvider
     * @param array $construct
     * @param $queryValue
     */
    public function testToArray(array $construct, $queryValue)
    {
        $searchRequest = new SearchRequest($construct);

        $this->assert()
            ->internalType('array', $searchRequest->toArray())
            ->notEmpty($searchRequest)
            ->same($queryValue, $searchRequest->toArray()['q']);
    }

    public static function paramProvider()
    {
        return [
            [[], null],
            [['q' => 'query'], 'query']
        ];
    }
}
