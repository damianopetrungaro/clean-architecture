<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\CollectionRequest;
use PHPUnit\Framework\TestCase;
use SplObjectStorage;

class RequestTest extends TestCase
{
    /**
     * Check that CollectionRequest object when use all method return the collection all content
     *
     * @param $value
     *
     * @dataProvider allMethodDataProvider
     */
    public function testAllMethod($value)
    {
        $collection = $this->prophesize(Collection::class);
        $collection->all()->shouldBeCalledTimes(1)->willReturn($value);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $this->assertSame($request->all(), $value);
    }

    /**
     * Check that CollectionRequest object when use clear method return a new request with an new empty collection object
     *
     */
    public function testClearMethod()
    {
        $newEmptyCollection = $this->prophesize(Collection::class);
        $newEmptyCollection->all()->shouldBeCalledTimes(1)->willReturn([]);
        $newEmptyCollection = $newEmptyCollection->reveal();

        $collection = $this->prophesize(Collection::class);
        $collection->clear()->shouldBeCalledTimes(1)->willReturn($newEmptyCollection);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $emptyRequest = $request->clear();
        $this->assertSame([], $emptyRequest->all());
    }

    /**
     * Check that CollectionRequest object when use get method return the collection 'get' value
     * Also check that the key and default properties are correctly passed
     *
     * @param $value
     * @param $key
     * @param $default
     *
     * @dataProvider getMethodDataProvider
     */
    public function testGetMethod($value, $key, $default = null)
    {
        $collection = $this->prophesize(Collection::class);
        $collection->get($key, $default)->shouldBeCalledTimes(1)->willReturn($value);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $this->assertSame($request->get($key, $default), $value);
    }

    /**
     * Check that CollectionRequest object when use has method return the collection 'has' value
     *
     * @param $value
     * @param $key
     *
     * @dataProvider hasMethodDataProvider
     */
    public function testHasMethod($value, $key)
    {
        $collection = $this->prophesize(Collection::class);
        $collection->has($key)->shouldBeCalledTimes(1)->willReturn($value);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $this->assertSame($request->has($key), $value);
    }

    /**
     * Check that CollectionRequest object when use with method return a new collection
     *
     * @param $value
     * @param $key
     *
     * @dataProvider withMethodDataProvider
     */
    public function testWithMethod($value, $key = null)
    {
        $newCollection = $this->prophesize(Collection::class);
        $newCollection->all()->shouldBeCalledTimes(1)->willReturn([]);
        $newCollection = $newCollection->reveal();

        $collection = $this->prophesize(Collection::class);
        $collection->with($value, $key)->shouldBeCalledTimes(1)->willReturn($newCollection);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $emptyRequest = $request->with($value, $key);
        $this->assertSame([], $emptyRequest->all());
    }

    /**
     * Check that CollectionRequest object when use without method return a new collection
     *
     * @param $key
     *
     * @dataProvider withoutMethodDataProvider
     */
    public function testWithoutMethod($key)
    {
        $newCollection = $this->prophesize(Collection::class);
        $newCollection->all()->shouldBeCalledTimes(1)->willReturn([]);
        $newCollection = $newCollection->reveal();

        $collection = $this->prophesize(Collection::class);
        $collection->without($key)->shouldBeCalledTimes(1)->willReturn($newCollection);
        $collection = $collection->reveal();

        $request = new CollectionRequest($collection);
        $emptyRequest = $request->without($key);
        $this->assertSame([], $emptyRequest->all());
    }

    /**
     * @return array
     */
    public function allMethodDataProvider()
    {
        return [
            [['key' => 'value']],
            [['key' => ['nestedKey' => 'nestedValue']]]
        ];
    }

    /**
     * @return array
     */
    public function getMethodDataProvider()
    {
        return [['a value', 'a key', 'a default'], ['a value', 'key without default'], [null, 0]];
    }

    /**
     * @return array
     */
    public function hasMethodDataProvider()
    {
        return [[true, 'keyOne'], [false, 'keyTwo']];
    }

    /**
     * @return array
     */
    public function withMethodDataProvider()
    {
        return [['value', 'key'], [new SplObjectStorage(), 0], ['value']];
    }

    /**
     * @return array
     */
    public function withoutMethodDataProvider()
    {
        return [['key'], [0]];
    }
}