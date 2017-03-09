<?php

namespace Damianopetrungaro\CleanArchitecture\Unit\UseCase\Response;

use Damianopetrungaro\CleanArchitecture\Common\Collection\CollectionInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check that Response object when initialized set 'data' and 'errors' properties as CollectionInterface
     *
     */
    public function testThatResponseOnInitSetErrorAndData()
    {
        $data = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errors = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $response = new Response($data, $errors);
        $reflection = new \ReflectionClass($response);

        $dataCollectionReflected = $reflection->getProperty('data');
        $dataCollectionReflected->setAccessible(true);
        $this->assertTrue($dataCollectionReflected->getValue($response) instanceof CollectionInterface);

        $errorsCollectionReflected = $reflection->getProperty('errors');
        $errorsCollectionReflected->setAccessible(true);
        $this->assertTrue($errorsCollectionReflected->getValue($response) instanceof CollectionInterface);
    }

    /**
     * Test that the addData method push new element into an array
     *
     * @param $fakeInitialArray
     * @param $value
     * @param $expectedValue
     * @internal param $key
     * @dataProvider addDataMethodDataProvider
     */
    public function testAddDataMethod($fakeInitialArray, $value, $expectedValue)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->getMockForAbstractClass();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'get' method calls will return a fake value
        $dataCollectionMock->method('get')->will($this->returnValue($fakeInitialArray));
        // On 'with' method calls will assert the expected behavior (add into an array or set an empty array with a value)
        // And return a CollectionInterface because the return type is specified
        $dataCollectionMock->method('with')->will($this->returnCallback(function ($value) use ($expectedValue) {
            $this->assertEquals($expectedValue, $value);

            return $this->getMockBuilder(CollectionInterface::class)->getMock();
        }));

        // Create Response and call addData method
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $response->addData('key', $value);
    }

    /**
     * Test that the addError method push new error into an array
     *
     * @param $fakeInitialArray
     * @param $value
     * @param $expectedValue
     * @internal param $key
     * @dataProvider addErrorMethodDataProvider
     */
    public function testAddErrorMethod($fakeInitialArray, $value, $expectedValue)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->getMockForAbstractClass();
        // On 'get' method calls will return a fake value
        $errorCollectionMock->method('get')->will($this->returnValue($fakeInitialArray));
        // On 'with' method calls will assert the expected behavior (add into an array or set an empty array with a value)
        // And return a CollectionInterface because the return type is specified
        $errorCollectionMock->method('with')->will($this->returnCallback(function ($value) use ($expectedValue) {
            $this->assertTrue($expectedValue === $value);

            return $this->getMockBuilder(CollectionInterface::class)->getMock();
        }));

        // Create Response and call addData method
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $response->addError('key', $value);
    }

    /**
     * Test that the getData and getErrors method return an expected collection's array
     *
     * @param array $expected
     * @param array $actual
     * @dataProvider getDataAndGetErrorsMethodAreEqualsDataProvider
     */
    public function testGetDataAndGetErrorsMethodAreEquals(array $expected, array $actual)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'all' method calls will return a fake value
        $dataCollectionMock->method('all')->will($this->returnValue($expected));
        $errorCollectionMock->method('all')->will($this->returnValue($expected));
        // Create Response and call getData,getErrors methods
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $this->assertEquals($response->getData(), $actual);
        $this->assertEquals($response->getErrors(), $actual);
    }

    /**
     * Test that the getData and getErrors method return a different collection's array
     *
     * @param array $expected
     * @param array $actual
     * @dataProvider getDataAndGetErrorsMethodAreNotEqualsDataProvider
     */
    public function testGetDataAndErrorsMethodAreNotEquals(array $expected, $actual)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'all' method calls will return a fake value
        $dataCollectionMock->method('all')->will($this->returnValue($expected));
        $errorCollectionMock->method('all')->will($this->returnValue($expected));
        // Create Response and call getData, getErrors methods
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $this->assertNotEquals($response->getData(), $actual);
        $this->assertNotEquals($response->getErrors(), $actual);
    }

    /**
     * Test that the hasData and hasErrors method return an expected value
     *
     * @param array $expected
     * @param array $actual
     * @dataProvider hasDataAndHasErrorsMethodAreEqualsDataProvider
     */
    public function testHasDataAndHasErrorsMethodAreEquals($expected, $actual)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'length' method calls will return a fake value
        $dataCollectionMock->method('length')->will($this->returnValue($expected));
        $errorCollectionMock->method('length')->will($this->returnValue($expected));
        // Create Response and call hasData, hasErrors methods
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $this->assertEquals($response->hasData(), $actual);
        $this->assertEquals($response->hasErrors(), $actual);
    }

    /**
     * Test that the hasData and hasErrors method return a different expected value
     *
     * @param array $expected
     * @param array $actual
     * @dataProvider hasDataAndHasErrorsMethodAreNotEqualsDataProvider
     */
    public function testHasDataAndHasErrorsMethodAreNotEquals($expected, $actual)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'length' method calls will return a fake value
        $dataCollectionMock->method('length')->will($this->returnValue($expected));
        $errorCollectionMock->method('length')->will($this->returnValue($expected));
        // Create Response and call hasData, hasErrors methods
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $this->assertNotEquals($response->hasData(), $actual);
        $this->assertNotEquals($response->hasErrors(), $actual);
    }

    /**
     * Test that is failed return right value
     *
     * @param $expected
     * @param $value
     * @dataProvider isFailedMethodAreEqualsDataProvider
     */
    public function testIsFailedMethod($expected, $value)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // Create Response and call isFailed method after set the status
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $responseReflected = new \ReflectionClass($response);
        $statusReflected = $responseReflected->getProperty('status');
        $statusReflected->setAccessible(true);
        $statusReflected->setValue($response, $value);
        $this->assertEquals($response->isFailed(), $expected);
    }

    /**
     * Test that is successful return right value
     *
     * @param $expected
     * @param $value
     * @dataProvider isSuccessMethodAreEqualsDataProvider
     */
    public function testIsSuccessfulMethod($expected, $value)
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // Create Response and call isFailed method after set the status
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $responseReflected = new \ReflectionClass($response);
        $statusReflected = $responseReflected->getProperty('status');
        $statusReflected->setAccessible(true);
        $statusReflected->setValue($response, $value);
        $this->assertEquals($response->isSuccessful(), $expected);
    }

    /**
     * Test that removeData method set a new collection on data property
     */
    public function testRemoveDataErrorMethod()
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'without' method calls will assert the expected behavior (return a new collection)
        // And return a CollectionInterface because the return type is specified
        $dataCollectionMock->method('without')->will($this->returnCallback(function () {
            return $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        }));

        $response = new Response($dataCollectionMock, $errorCollectionMock);
        // Set accessible data and errors property
        $responseReflected = new \ReflectionClass($response);
        $dataReflected = $responseReflected->getProperty('data');
        $dataReflected->setAccessible(true);
        // Get data, change it and get the new one that has been set
        $firstDataCollection = $dataReflected->getValue($response);
        $response->removeData('key');
        $secondDataCollection = $dataReflected->getValue($response);
        // The instance id must be different
        $this->assertNotEquals(spl_object_hash($firstDataCollection), spl_object_hash($secondDataCollection));
    }


    /**
     * Test that removeError method set a new collection on errors property
     */
    public function testRemoveDataAndRemoveErrorMethod()
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // On 'without' method calls will assert the expected behavior (return a new collection)
        // And return a CollectionInterface because the return type is specified
        $errorCollectionMock->method('without')->will($this->returnCallback(function () {
            return $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        }));

        $response = new Response($dataCollectionMock, $errorCollectionMock);
        // Set accessible data and errors property
        $responseReflected = new \ReflectionClass($response);
        $errorReflected = $responseReflected->getProperty('errors');
        $errorReflected->setAccessible(true);
        // Get errors, change it and get the new one that has been set
        $firstErrorCollection = $errorReflected->getValue($response);
        $response->removeError('key');
        $secondErrorCollection = $errorReflected->getValue($response);
        
        $this->assertNotEquals(spl_object_hash($firstErrorCollection), spl_object_hash($secondErrorCollection));
    }

    /**
     * Test that setAsFailed set right value
     *
     */
    public function testSetAsFailedMethod()
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // Create Response and call setAsFailed method
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $response->setAsFailed();
        // Check the validity of status
        $responseReflected = new \ReflectionClass($response);
        $statusReflected = $responseReflected->getProperty('status');
        $statusReflected->setAccessible(true);
        $this->assertEquals($statusReflected->getValue($response), 'FAILED');
        $this->assertNotEquals($statusReflected->getValue($response), 'SUCCESSFUL');
    }

    /**
     * Test that setAsSuccessful set right value
     *
     */
    public function testSetAsSuccessfulMethod()
    {
        // Create a mock for data and error
        $dataCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        $errorCollectionMock = $this->getMockBuilder(CollectionInterface::class)->disableOriginalConstructor()->getMock();
        // Create Response and call setAsSuccess method
        $response = new Response($dataCollectionMock, $errorCollectionMock);
        $response->setAsSuccess();
        // Check the validity of status
        $responseReflected = new \ReflectionClass($response);
        $statusReflected = $responseReflected->getProperty('status');
        $statusReflected->setAccessible(true);
        $this->assertEquals($statusReflected->getValue($response), 'SUCCESSFUL');
        $this->assertNotEquals($statusReflected->getValue($response), 'FAILED');
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function addDataMethodDataProvider()
    {
        return [
            [[], 'value', ['value']],
            [['a', 'b', 'c'], 'd', ['a', 'b', 'c', 'd']],
            [['firstKey' => 'firstValue'], 'secondValue', ['secondValue', 'firstKey' => 'firstValue']],
        ];
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function addErrorMethodDataProvider()
    {
        $firstError = $this->getMockedError();
        $secondError = $this->getMockedError();
        $arrayErrors = $this->getMockedError(3);
        $expectedArray = $arrayErrors;
        array_push($expectedArray, $secondError);

        return [
            [[], $firstError, [$firstError]],
            [$arrayErrors, $secondError, $expectedArray],
        ];
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function getDataAndGetErrorsMethodAreEqualsDataProvider()
    {
        return [
            [[], []],
            [['key' => 'value'], ['key' => 'value']],
            [['key' => ['nested' => 'value']], ['key' => ['nested' => 'value']]]
        ];
    }

    /**
     * TODO Add Description
     *
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
     * TODO Add Description
     *
     * @return array
     */
    public function hasDataAndHasErrorsMethodAreEqualsDataProvider()
    {
        return [[0, false], [12, true], [1, true]];
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function hasDataAndHasErrorsMethodAreNotEqualsDataProvider()
    {
        return [[0, true], [12, false], [1, false]];
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function isFailedMethodAreEqualsDataProvider()
    {
        return [[true, 'FAILED'], [false, 'FAIL'], [false, 'SUCCESS']];
    }

    /**
     * TODO Add Description
     *
     * @return array
     */
    public function isSuccessMethodAreEqualsDataProvider()
    {
        return [[true, 'SUCCESSFUL'], [false, 'SUCCESS'], [false, 'FAILED']];
    }

    /**
     * Helper for return one or an array of ErrorInterface
     *
     * @param int $number
     *
     * @return mixed
     */
    private function getMockedError(int $number = 1)
    {
        if ($number <= 1) {
            return $this->getMockBuilder(ErrorInterface::class)->getMockForAbstractClass();
        }

        $errors = [];
        for ($i = 0; $i < $number; $i++) {
            $errors[] = $this->getMockedError();
        }

        return $errors;
    }
}