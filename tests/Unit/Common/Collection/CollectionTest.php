<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\Common\Collection;

use ArrayIterator;
use ArrayObject;
use Damianopetrungaro\CleanArchitecture\Common\Collection\ArrayCollection;
use PHPUnit\Framework\TestCase;
use SplObjectStorage;

class CollectionTest extends TestCase
{
    /**
     * Check that the items passed in the constructor is correctly assigned
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testCollectionInit($items)
    {
        $collection = new ArrayCollection($items);
        $this->assertSame($collection->all(), $items);
    }

    /**
     * Check that the items retrieved is the same inserted
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testAllMethod($items)
    {
        $collection = new ArrayCollection($items);
        $this->assertSame($collection->all(), $items);
    }

    /**
     * Check that the new instance of collection returned from clear has no items
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testClearMethod($items)
    {
        $collection = new ArrayCollection($items);
        $collection = $collection->clear();
        $this->assertSame($collection->all(), []);
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
        $collection = new ArrayCollection($items);
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
        $collection = new ArrayCollection($items);
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
        $collection = new ArrayCollection($items);
        $this->assertSame($collection->get($expectedKey), $expectedValue);
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
        $collection = new ArrayCollection($items);
        $this->assertSame($collection->get($expectedKey, $expectedValue), $expectedValue);
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
    public function testHasMethod($items, $requiredKey, $expectedValue)
    {
        $collection = new ArrayCollection($items);
        $this->assertSame($collection->has($requiredKey), $expectedValue);
    }

    /**
     * Check that keys method return all the inserted keys
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testKeysMethod($items)
    {
        $collection = new ArrayCollection($items);
        $keys = array_keys($items);
        $this->assertSame($collection->keys(), $keys);
    }

    /**
     * Check that the expected length is right
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testLengthMethod($items)
    {
        $collection = new ArrayCollection($items);
        $length = count($items);
        $this->assertSame($collection->length(), $length);
    }

    /**
     * Check that the merged collection contains all the expected data
     *
     */
    public function testMergeWithMethod()
    {
        $collection1 = new ArrayCollection(['a', 'b']);
        $collection2 = new ArrayCollection(['c', 'd']);
        $collection3 = new ArrayCollection(['e' => 'val-e', 'f' => 'val-f']);
        $final = new ArrayCollection(['a', 'b', 'c', 'd', 'e' => 'val-e', 'f' => 'val-f']);
        $this->assertEquals($final, $collection1->mergeWith($collection2, $collection3));
    }

    /**
     * Check that the returned collection haven't the removed key
     *
     */
    public function testWithoutMethod()
    {
        $collection1 = new ArrayCollection(['key1' => 'value1', 'key2' => 'value2']);
        $final = new ArrayCollection(['key2' => 'value2']);
        $this->assertEquals($final, $collection1->without('key1'));
    }

    /**
     * Check that the returned collection have the inserted key
     *
     */
    public function testWithMethod()
    {
        $collection1 = new ArrayCollection(['key2' => 'value2']);
        $final = new ArrayCollection(['key1' => 'value1', 'key2' => 'value2']);
        $this->assertEquals($final, $collection1->with('value1', 'key1'));
    }

    /**
     * Check that all the values inserted is returned
     *
     * @param $items
     *
     * @dataProvider itemsDataProviders
     */
    public function testValuesMethod($items)
    {
        $collection = new ArrayCollection($items);
        $keys = array_values($items);
        $this->assertSame($collection->values(), $keys);
    }

    /**
     * Check that iterator works as expected
     *
     */
    public function testIterability()
    {
        $keys = ['key-0', 'key-1'];
        $indexKey = 0;
        $items = ['key-0' => 'value-0', 'key-1' => 'value-1'];
        $collection = new ArrayCollection($items);
        foreach ($collection as $key => $value) {
            $this->assertSame($items[$keys[$indexKey]], $value);
            $indexKey++;
        }
    }

    /**
     * Check that the clone of the ArrayCollection is a deep clone.
     * All the object inside the collection must be cloned too.
     */
    public function testDeepClone()
    {
        // The array has object nested object inside
        $items = [
            'very' => [
                'deep' => new SplObjectStorage()
            ],
            'simple' => 'variable',
            'deep' => new ArrayIterator(),
            new ArrayObject()
        ];

        // Init and clone the object
        $collection = new ArrayCollection($items);
        $clonedCollection = clone $collection;

        // Object has the same type
        $this->assertEquals($clonedCollection->get(0), $collection->get(0));
        $this->assertEquals($clonedCollection->get('deep'), $collection->get('deep'));
        $this->assertEquals($clonedCollection->get('simple'), $collection->get('simple'));
        $this->assertEquals($clonedCollection->get('very')['deep'], $collection->get('very')['deep']);

        // Object is not the same instance
        $this->assertNotSame(spl_object_hash($clonedCollection->get(0)), spl_object_hash($collection->get(0)));
        $this->assertNotSame(spl_object_hash($clonedCollection->get('deep')), spl_object_hash($collection->get('deep')));
        $this->assertNotSame(spl_object_hash($clonedCollection->get('very')['deep']), spl_object_hash($collection->get('very')['deep']));
    }

    /**
     * @return array
     */
    public function itemsDataProviders()
    {
        return [
            [['key1' => 0, 'secondKey' => 'a value', 'onlyValue']],
            [[new SplObjectStorage(), 'b' => 'sample', 'c' => 'anotherSample']],
        ];
    }


    /**
     * @return array
     */
    public function itemsWithValidValueForTestContainsMethodDataProviders()
    {
        $object = new SplObjectStorage();

        return [
            [['key1' => 'value1'], 'value1'],
            [[1], 1],
            [[$object], $object],
        ];
    }

    /**
     * @return array
     */
    public function itemsWithInvalidValueForTestContainsMethodDataProviders()
    {
        return [
            [['key1' => 'value1'], 'no value'],
            [[1], 2],
            [[new SplObjectStorage()], new SplObjectStorage()],
        ];
    }

    /**
     * @return array
     */
    public function itemsWithValidKeyValueForTestGetMethodDataProviders()
    {
        $object = new SplObjectStorage();

        return [
            [['key1' => 'value1'], 'key1', 'value1'],
            [[1 => 0], 1, 0],
            [['object' => $object], 'object', $object],
        ];
    }

    /**
     * @return array
     */
    public function itemsWithInvalidKeyValueForTestGetMethodDataProviders()
    {
        return [
            [['key1' => 'value1'], 'key2', 'default'],
            [[1 => 0], 0, 'default_number'],
            [['object' => null], 'object', null],
        ];
    }

    /**
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
