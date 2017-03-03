<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Collection;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check that the items passed in the constructor is correctly assigned
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
     * Check that the items retrieved is the same inserted
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
     * Check that the new instance of collection returned from clear has no items
     *
     * @param $items
     * @dataProvider itemsDataProviders
     */
    public function testClearMethod($items)
    {
        $collection = new Collection($items);
        $collection = $collection->clear();
        $this->assertEquals($collection->all(), []);
    }

    /**
     * Check that the contains method correctly controls the existence of required values
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
     * Check that the contains method correctly controls the inexistence of required values
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
     * Check that get method return inserted values
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
     * Check that get method return default values
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
     * Check that has method return expected result
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
     * Check that keys method return all the inserted keys
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
     * Check that the expected length is right
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

    /**
     * Check that the merged collection contains all the expected data
     *
     */
    public function testMergeWith()
    {
        $collection1 = new Collection(['a', 'b']);
        $collection2 = new Collection(['c', 'd']);
        $collection3 = new Collection(['e' => 'val-e', 'f' => 'val-f']);
        $final = new Collection(['a', 'b', 'c', 'd', 'e' => 'val-e', 'f' => 'val-f']);
        $this->assertTrue($final == $collection1->mergeWith($collection2, $collection3));
    }

    /**
     * Check that the returned collection haven't the removed key
     *
     */
    public function testWithout()
    {
        $collection1 = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $final = new Collection(['key2' => 'value2']);
        $this->assertTrue($final == $collection1->without('key1'));
    }

    /**
     * Check that the returned collection have the inserted key
     *
     */
    public function testWith()
    {
        $collection1 = new Collection(['key2' => 'value2']);
        $final = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $this->assertTrue($final == $collection1->with('value1', 'key1'));
    }

    /**
     * Check that all the values inserted is returned
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
     * Check that iterator works as expected
     *
     */
    public function testIterator()
    {
        $keys = ['key-0', 'key-1'];
        $indexKey = 0;
        $items = ['key-0' => 'value-0', 'key-1' => 'value-1'];
        $collection = new Collection($items);
        foreach ($collection->getIterator() as $key => $value) {
            $this->assertTrue($items[$keys[$indexKey]] === $value);
            $indexKey++;
        }
    }

    /**
     * Check that the clone of the Collection is a deep clone.
     * All the object inside the collection must be cloned too.
     */
    public function testDeepClone()
    {
        // The array has object nested object inside
        $items = [
            'very' => [
                'deep' => new \SplObjectStorage()
            ],
            'simple' => 'variable',
            'deep' => new \ArrayIterator(),
            new \ArrayObject()
        ];

        // Init and clone the object
        $collection = new Collection($items);
        $clonedCollection = clone $collection;

        // Object has the same type
        $this->assertTrue($clonedCollection->get(0) == $collection->get(0));
        $this->assertTrue($clonedCollection->get('deep') == $collection->get('deep'));
        $this->assertTrue($clonedCollection->get('simple') == $collection->get('simple'));
        $this->assertTrue($clonedCollection->get('very')['deep'] == $collection->get('very')['deep']);

        // Object is not the same instance
        $this->assertTrue($clonedCollection->get(0) !== $collection->get(0));
        $this->assertTrue($clonedCollection->get('deep') !== $collection->get('deep'));
        $this->assertTrue($clonedCollection->get('very')['deep'] !== $collection->get('very')['deep']);
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