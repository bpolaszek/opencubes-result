<?php

namespace OpenCubes\Tests;

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

use OpenCubes\Result\Model\Result;

class ResultItemsTest extends TestCase
{

    public function testResultWithNull()
    {
        $result = new Result();
        $this->assertNull($result->getItems());
        $this->assertTrue(is_iterable($result));
        $this->assertEquals([], iterable_to_array($result));
    }

    public function testResultWithArray()
    {
        $items = [
            'foo' => 'bar',
        ];
        $result = new Result();
        $result->setItems($items);
        $this->assertEquals($items, $result->getItems());
        $this->assertTrue(is_iterable($result));
        $this->assertEquals($items, iterable_to_array($result));
    }

    public function testResultWithIterator()
    {
        $items = new \ArrayIterator([
            'foo' => 'bar',
        ]);
        $result = new Result();
        $result->setItems($items);
        $this->assertEquals($items, $result->getItems());
        $this->assertTrue(is_iterable($result));
        $this->assertEquals($items->getArrayCopy(), iterable_to_array($result));
    }

    public function testResultWithGenerator()
    {
        $items = function () {
            yield 'foo' => 'bar';
        };
        $result = new Result();
        $result->setItems($items());
        $this->assertInstanceOf(\Generator::class, $result->getItems());
        $this->assertTrue(is_iterable($result));
        $this->assertEquals(['foo' => 'bar'], iterable_to_array($result));
    }

    public function testResultWithPromise()
    {
        $promise = new Promise(function () use (&$promise) {
            $promise->resolve(['foo' => 'bar']);
        });

        $result = new Result();
        $result->setItems($promise);
        $this->assertNotInstanceOf(PromiseInterface::class, $result->getItems(), 'Promise must be resolved when calling Result::getItems().');
        $this->assertEquals(['foo' => 'bar'], $result->getItems());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testResultWithInvalid()
    {
        $result = new Result();
        $result->setItems('foo');
    }
}
