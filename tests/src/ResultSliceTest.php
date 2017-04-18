<?php

namespace OpenCubes\Tests;

use OpenCubes\Result\Model\Result;
use GuzzleHttp\Promise\Promise;
use PHPUnit\Framework\TestCase;

class ResultSliceTest extends TestCase
{
    public function testScalar()
    {
        $result = new Result();
        $result->setOffset(100);
        $result->setLength(50);
        $result->setNumFound(500);
        $this->assertEquals(100, $result->getOffset());
        $this->assertEquals(50, $result->getLength());
        $this->assertEquals(500, $result->getNumFound());
    }

    public function testPromise()
    {
        $result = new Result();
        $result->setOffset($this->createPromise(100));
        $result->setLength($this->createPromise(50));
        $result->setNumFound($this->createPromise(500));
        $this->assertEquals(100, $result->getOffset());
        $this->assertEquals(50, $result->getLength());
        $this->assertEquals(500, $result->getNumFound());
    }

    private function createPromise($value)
    {
        $promise = new Promise(function () use (&$promise, $value) {
            $promise->resolve($value);
        });
        return $promise;
    }
}
