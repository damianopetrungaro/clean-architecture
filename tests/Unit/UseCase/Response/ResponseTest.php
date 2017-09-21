<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Response;

use Damianopetrungaro\CleanArchitecture\Common\Collection\Collection;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\Error;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\CollectionResponse;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * Test that the replaceData method replace the data
     *
     * @param $valueì
     *
     * @dataProvider replaceDataMethodDataProvider
     */
    public function testReplaceDataMethod($value)
    {
        // Create a mock for data and error
        $dataCollection = $this->prophesize(Collection::class);
        $dataCollection->with('key', $value)->shouldBeCalledTimes(1);
        $dataCollection = $dataCollection->reveal();
        $errorCollection = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call replaceData method
        $response = new CollectionResponse($dataCollection, $errorCollection);
        $response->replaceData('key', $value);
    }

    /**
     * Test that the addError method replace the errors
     *
     * @param $value
     * @param $expectedValue
     *
     * @dataProvider replaceErrorMethodDataProvider
     */
    public function testReplaceErrorMethod($value)
    {
        // Create a mock for data and error
        $errorCollection = $this->prophesize(Collection::class);
        $errorCollection->with('key', $value)->shouldBeCalledTimes(1);
        $errorCollection = $errorCollection->reveal();
        $dataCollection = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call replaceData method
        $response = new CollectionResponse($dataCollection, $errorCollection);
        $response->replaceError('key', $value);
    }

    /**
     * Test that the addData method add data to the response
     *
     * @param $fakeInitialArray
     * @param $value
     * @param $expectedValue
     *
     * @dataProvider addDataMethodDataProvider
     */
    public function testAddDataMethod($fakeInitialArray, $value, $expectedValue)
    {
        // Create a mock for data and error
        $dataCollection = $this->prophesize(Collection::class);
        $dataCollection->get('key', [])->shouldBeCalledTimes(1)->willReturn($fakeInitialArray);
        $dataCollection->with('key', $expectedValue)->shouldBeCalledTimes(1);
        $dataCollection = $dataCollection->reveal();
        $errorCollection = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call replaceData method
        $response = new CollectionResponse($dataCollection, $errorCollection);
        $response->addData('key', $value);
    }

    /**
     * Test that the addError add Errorto the response
     *
     * @param $fakeInitialArray
     * @param $value
     * @param $expectedValue
     *
     * @dataProvider addErrorMethodDataProvider
     */
    public function testAddErrorMethod($fakeInitialArray, $value, $expectedValue)
    {
        // Create a mock for data and error
        $errorCollection = $this->prophesize(Collection::class);
        $errorCollection->get('key', [])->shouldBeCalledTimes(1)->willReturn($fakeInitialArray);
        $errorCollection->with('key', $expectedValue)->shouldBeCalledTimes(1);
        $errorCollection = $errorCollection->reveal();
        $dataCollection = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call replaceData method
        $response = new CollectionResponse($dataCollection, $errorCollection);
        $response->addError('key', $value);
    }

    /**
     * Test that the getData and getErrors method return an expected collection's array
     *
     * @param array $expected
     * @param array $actual
     *
     * @dataProvider getDataAndGetErrorsMethodDataProvider
     */
    public function testGetDataAndGetErrors(array $expected, array $actual)
    {
        // Create a mock for data and error
        $collectionProphecy = $this->prophesize(Collection::class);
        $collectionProphecy->all()->willReturn($expected);
        $collectionProphecy = $collectionProphecy->reveal();
        // Create CollectionResponse and call getData,getErrors methods
        $response = new CollectionResponse($collectionProphecy, $collectionProphecy);
        $this->assertSame($response->getData(), $actual);
        $this->assertSame($response->getErrors(), $actual);
    }

    /**
     * Test that the hasData and hasErrors method return an expected value
     *
     * @param array $expected
     * @param array $actual
     *
     * @dataProvider hasDataAndHasErrorsMethodAreEqualsDataProvider
     */
    public function testHasDataAndHasErrorsMethodAreEquals($expected, $actual)
    {
        // Create a mock for data and error
        $collectionProphecy = $this->prophesize(Collection::class);
        $collectionProphecy->length()->willReturn($expected);
        $collectionProphecy = $collectionProphecy->reveal();

        // Create CollectionResponse and call hasData, hasErrors methods
        $response = new CollectionResponse($collectionProphecy, $collectionProphecy);
        $this->assertSame($response->hasData(), $actual);
        $this->assertSame($response->hasErrors(), $actual);
    }

    /**
     * Test that is failed return right value
     */
    public function testIsFailedMethod()
    {
        // Create a mock for data and error
        $collectionProphecy = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call isFailed method after set the status
        $response = new CollectionResponse($collectionProphecy, $collectionProphecy);
        $response->setAsFailed();
        $this->assertTrue($response->isFailed());
        $this->assertFalse($response->isSuccessful());
    }

    /**
     * Test that is failed return right value
     */
    public function testIsSuccessfulMethod()
    {
        // Create a mock for data and error
        $collectionProphecy = $this->prophesize(Collection::class)->reveal();

        // Create CollectionResponse and call isFailed method after set the status
        $response = new CollectionResponse($collectionProphecy, $collectionProphecy);
        $response->setAsSuccess();
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isFailed());
    }

    /**
     * Test that removeData method set a new collection on data property
     */
    public function testRemoveDataAndErrorMethod()
    {
        // Create a mock for data and error
        $collection = $this->prophesize(Collection::class);
        $collection->without('key')->shouldBeCalledTimes(2)->willReturn($collection->reveal());
        $collection = $collection->reveal();

        $response = new CollectionResponse($collection, $collection);
        $response->removeData('key');
        $response->removeError('key');
    }

    /**
     * // TODO Add description
     *
     * @return array
     */
    public function replaceDataMethodDataProvider()
    {
        return [
            ['value'],
            ['d'],
            ['secondValue'],
        ];
    }


    /**
     * // TODO Add description
     *
     * @return array
     */
    public function addDataMethodDataProvider()
    {
        return [
            [[], 'value', ['value']],
            ['hello', 'value', ['hello', 'value']],
            [['a', 'b', 'c'], 'd', ['a', 'b', 'c', 'd']],
            [['firstKey' => 'firstValue'], 'secondValue', ['secondValue', 'firstKey' => 'firstValue']],
        ];
    }

    /**
     * @return array
     */
    public function addErrorMethodDataProvider()
    {
        $firstError = $this->getErrorsList();
        $secondError = $this->getErrorsList();
        $arrayErrors = $this->getErrorsList(3);
        $expectedArray = $arrayErrors;
        array_push($expectedArray, $secondError);

        return [
            [[], $firstError, [$firstError]],
            [$arrayErrors, $secondError, $expectedArray],
        ];
    }

    /**
     * @return array
     */
    public function replaceErrorMethodDataProvider()
    {
        return [
            [$this->getErrorsList()],
        ];
    }

    /**
     * @return array
     */
    public function getDataAndGetErrorsMethodDataProvider()
    {
        return [
            [[], []],
            [['key' => 'value'], ['key' => 'value']],
            [['key' => ['nested' => 'value']], ['key' => ['nested' => 'value']]]
        ];
    }

    /**
     * @return array
     */
    public function getDataAndGetErrorsMethodAreNotEqualsDataProvider()
    {
        return [
            [[], ''],
            [['value'], [1 => 'value']],
            [['key' => ['nested' => 'value']], ['key' => [0 => 'value']]]
        ];
    }

    /**
     * @return array
     */
    public function hasDataAndHasErrorsMethodAreEqualsDataProvider()
    {
        return [[0, false], [12, true], [1, true]];
    }

    /**
     * @return array
     */
    public function hasDataAndHasErrorsMethodAreNotEqualsDataProvider()
    {
        return [[0, true], [12, false], [1, false]];
    }

    /**
     * @return array
     */
    public function isFailedMethodAreEqualsDataProvider()
    {
        return [[true, 'FAILED'], [false, 'FAIL'], [false, 'SUCCESS']];
    }

    /**
     * @return array
     */
    public function isSuccessMethodAreEqualsDataProvider()
    {
        return [[true, 'SUCCESSFUL'], [false, 'SUCCESS'], [false, 'FAILED']];
    }

    /**
     * Helper for return one or an array of Error
     *
     * @param int $number
     *
     * @return mixed
     */
    private function getErrorsList(int $number = 1)
    {
        if ($number <= 1) {
            return $this->prophesize(Error::class)->reveal();
        }

        $errors = [];
        for ($i = 0; $i < $number; $i++) {
            $errors[] = $this->prophesize(Error::class)->reveal();
        }

        return $errors;
    }
}