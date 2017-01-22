<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Collection;


use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testCollectionInit($items)
    {
        $collection = new Collection($items);
        $reflection = new \ReflectionClass($collection);
        $reflectedItems = $reflection->getProperty('items');
        $reflectedItems->setAccessible(true);
        $this->assertEquals($reflectedItems->getValue($collection), $items);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testAllMethod($items)
    {
        $collection = new Collection($items);
        $this->assertEquals($collection->all(), $items);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testClearMethod($items)
    {
        $collection = new Collection($items);
        $collection->clear();
        $this->assertEquals($collection->all(), []);
    }


    /**
     * TODO Add description
     *
     * @param $items
     * @param $expectedValue
     *
     * @dataProvider itemsWithValidValueForTestContainsMethodDataProviders
     */
    public function testContainsMethodExpectingTrue($items, $expectedValue)
    {
        $collection = new Collection($items);
        $this->assertTrue($collection->contains($expectedValue));
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @param $expectedValue
     *
     * @dataProvider itemsWithInvalidValueForTestContainsMethodDataProviders
     */
    public function testContainsMethodExpectingFalse($items, $expectedValue)
    {
        $collection = new Collection($items);
        $this->assertFalse($collection->contains($expectedValue));
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @param $expectedKey
     * @param $expectedValue
     *
     * @dataProvider itemsWithValidKeyValueForTestGetMethodDataProviders
     */
    public function testGetMethodExpectingNonDefaultValue($items, $expectedKey, $expectedValue)
    {
        $collection = new Collection($items);
        $this->assertEquals($collection->get($expectedKey), $expectedValue);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @param $expectedKey
     * @param $expectedValue
     *
     * @dataProvider itemsWithInvalidKeyValueForTestGetMethodDataProviders
     */
    public function testGetMethodExpectingDefaultValue($items, $expectedKey, $expectedValue)
    {
        $collection = new Collection($items);
        $this->assertEquals($collection->get($expectedKey, $expectedValue), $expectedValue);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @param $requiredKey
     * @param $expectedValue
     *
     * @dataProvider itemsWithKeyValueForTestHasMethodDataProviders
     */
    public function testHas($items, $requiredKey, $expectedValue)
    {
        $collection = new Collection($items);
        $this->assertEquals($collection->has($requiredKey), $expectedValue);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testKeys($items)
    {
        $collection = new Collection($items);
        $keys = array_keys($items);
        $this->assertEquals($collection->keys(), $keys);
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testLength($items)
    {
        $collection = new Collection($items);
        $length = count($items);
        $this->assertEquals($collection->length(), $length);
    }

    public function testMergeWith()
    {
        $collection1 = new Collection(['a', 'b']);
        $collection2 = new Collection(['c', 'd']);
        $collection3 = new Collection(['e' => 'val-e', 'f' => 'val-f']);
        $final = new Collection(['a', 'b', 'c', 'd', 'e' => 'val-e', 'f' => 'val-f']);
        $this->assertTrue($final == $collection1->mergeWith($collection2, $collection3));
    }

    public function testWithout()
    {
        $collection1 = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $final = new Collection(['key2' => 'value2']);
        $this->assertTrue($final == $collection1->without('key1'));
    }

    public function testWith()
    {
        $collection1 = new Collection(['key2' => 'value2']);
        $final = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $this->assertTrue($final == $collection1->with('value1', 'key1'));
    }

    /**
     * TODO Add description
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testValues($items)
    {
        $collection = new Collection($items);
        $keys = array_values($items);
        $this->assertEquals($collection->values(), $keys);
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsDataProviders()
    {
        return [
            [['key1' => 0, 'secondKey' => 'a value', 'onlyValue']],
            [[new \SplObjectStorage(), 'b' => 'sample', 'c' => 'anotherSample']],
        ];
    }


    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsWithValidValueForTestContainsMethodDataProviders()
    {
        $object = new \SplObjectStorage();
        return [
            [['key1' => 'value1'], 'value1'],
            [[1], 1],
            [[$object], $object],
        ];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsWithInvalidValueForTestContainsMethodDataProviders()
    {
        return [
            [['key1' => 'value1'], 'no value'],
            [[1], 2],
            [[new \SplObjectStorage()], new \SplObjectStorage()],
        ];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsWithValidKeyValueForTestGetMethodDataProviders()
    {
        $object = new \SplObjectStorage();
        return [
            [['key1' => 'value1'], 'key1', 'value1'],
            [[1 => 0], 1, 0],
            [['object' => $object], 'object', $object],
        ];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsWithInvalidKeyValueForTestGetMethodDataProviders()
    {
        return [
            [['key1' => 'value1'], 'key2', 'default'],
            [[1 => 0], 0, 'default_number'],
            [['object' => ''], 'object', null],
        ];
    }

    /**
     * TODO Add description
     *
     * @return array
     */
    public function itemsWithKeyValueForTestHasMethodDataProviders()
    {
        return [
            [['key1' => 'value1', 'key2' => 'value2'], 'key1', true],
            [[1 => 0, 'a.key' => 'a.value'], 0, false],
            [['object' => ''], 'object', true],
            [['Test.key' => '', 'value'], 'object', false],
        ];
    }
}