<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Request;


use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check that Request object when initialized set 'collection' properties as CollectionInterface
     *
     */
    public function testThatResponseOnInitSetCollection()
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $request = new Request($collectionMock);
        $requestReflected = new \ReflectionClass($request);

        $collectionReflected = $requestReflected->getProperty('collection');
        $collectionReflected->setAccessible(true);
        $this->assertTrue($collectionReflected->getValue($request) instanceof CollectionInterface);
    }

    /**
     * Check that Request object when use all method return the collection all content
     *
     * @param $value
     * @dataProvider allMethodDataProvider
     */
    public function testAllMethod($value)
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('all')->will($this->returnCallback(function () use ($value) {

            return $value;
        }));
        $request = new Request($collectionMock);
        $this->assertEquals($request->all(), $value);
    }

    /**
     * Check that Request object when use clear method return a new request with an new empty collection object
     *
     */
    public function testClearMethod()
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('clear')->will($this->returnCallback(function () {

            return $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        }));
        $request = new Request($collectionMock);
        $requestReflected = new \ReflectionClass($request);
        $collectionReflected = $requestReflected->getProperty('collection');
        $collectionReflected->setAccessible(true);
        $firstCollection = $collectionReflected->getValue($request);
        $emptyRequest = $request->clear();
        $secondCollection = $collectionReflected->getValue($emptyRequest);
        $this->assertNotEquals(spl_object_hash($request), spl_object_hash($emptyRequest));
        $this->assertNotEquals(spl_object_hash($firstCollection), spl_object_hash($secondCollection));
    }

    /**
     * Check that Request object when use get method return the collection 'get' value
     * Also check that the key and default properties are correctly passed
     *
     * @param $value
     * @param $key
     * @param $default
     * @dataProvider getMethodDataProvider
     */
    public function testGetMethod($value, $key, $default = null)
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('get')->will($this->returnCallback(function ($k, $d) use ($value, $key, $default) {
            $this->assertEquals($k, $key);
            $this->assertEquals($d, $default);

            return $value;
        }));
        $request = new Request($collectionMock);
        $this->assertEquals($request->get($key, $default), $value);
    }

    /**
     * Check that Request object when use has method return the collection 'has' value
     *
     * @param $value
     * @param $key
     * @dataProvider hasMethodDataProvider
     */
    public function testHasMethod($value, $key)
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('has')->will($this->returnCallback(function ($k) use ($value, $key) {
            $this->assertEquals($k, $key);

            return $value;
        }));
        $request = new Request($collectionMock);
        $this->assertEquals($request->has($key), $value);
    }

    /**
     * Check that Request object when use has method return a new collection
     *
     * @param $value
     * @param $key
     * @dataProvider withMethodDataProvider
     */
    public function testWithMethod($value, $key = null)
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('with')->will($this->returnCallback(function ($v, $k) use ($value, $key) {
            $this->assertEquals($k, $key);
            $this->assertEquals($v, $value);

            return $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        }));
        $request = new Request($collectionMock);
        $requestReflected = new \ReflectionClass($request);
        $collectionReflected = $requestReflected->getProperty('collection');
        $collectionReflected->setAccessible(true);
        $firstCollection = $collectionReflected->getValue($request);
        $newRequest = $request->with($value, $key);
        $secondCollection = $collectionReflected->getValue($newRequest);
        $this->assertNotEquals(spl_object_hash($request), spl_object_hash($newRequest));
        $this->assertNotEquals(spl_object_hash($firstCollection), spl_object_hash($secondCollection));
    }

    /**
     * Check that Request object when use has method return a new collection
     *
     * @param $key
     * @dataProvider withoutMethodDataProvider
     */
    public function testWithoutMethod($key)
    {
        $collectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $collectionMock->method('without')->will($this->returnCallback(function ($k) use ($key) {
            $this->assertEquals($k, $key);

            return $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        }));
        $request = new Request($collectionMock);
        $requestReflected = new \ReflectionClass($request);
        $collectionReflected = $requestReflected->getProperty('collection');
        $collectionReflected->setAccessible(true);
        $firstCollection = $collectionReflected->getValue($request);
        $newRequest = $request->without($key);
        $secondCollection = $collectionReflected->getValue($newRequest);
        $this->assertNotEquals(spl_object_hash($request), spl_object_hash($newRequest));
        $this->assertNotEquals(spl_object_hash($firstCollection), spl_object_hash($secondCollection));
    }

    /**
     * TODO Add description
     *
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
     * TODO Add description
     *
     * @return array
     */
    public function getMethodDataProvider()
    {
        return [['a value', 'a key', 'a default'], ['a value', 'key without default'], [null, 0]];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function hasMethodDataProvider()
    {
        return [[true, 'keyOne'], [false, 'keyTwo']];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function withMethodDataProvider()
    {
        return [['value', 'key'], [new \SplObjectStorage(), 0], ['value']];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function withoutMethodDataProvider()
    {
        return [['key'], [0]];
    }
}