<?php

namespace Jasny;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\Matcher\Invocation;

/**
 * Helper methods
 */
trait TestHelper
{
    /**
     * Returns a builder object to create mock objects using a fluent interface.
     *
     * @param string $className
     * @return MockBuilder
     */
    abstract public function getMockBuilder($className): MockBuilder;
    
    /**
     * Assert that the array contains the expected subset.
     * 
     * @param array       $subset
     * @param array|mixed $array
     * @param boolean     $strict
     * @param string      $message
     * @return void
     */
    abstract public function assertArraySubset($subset, $array, bool $strict = false, string $message = ''): void;
    
    
    /**
     * Call a private or protected method
     * 
     * @param object $object
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    protected function callPrivateMethod($object, string $method, array $args = [])
    {
        $refl = new \ReflectionMethod(get_class($object), $method);
        $refl->setAccessible(true);
        
        return $refl->invokeArgs($object, $args);
    }
    
    /**
     * Set a private or protected property
     * 
     * @param object $object
     * @param string $property
     * @param mixed  $value
     * @return mixed
     */
    protected function setPrivateProperty($object, string $property, $value)
    {
        $refl = new \ReflectionProperty(get_class($object), $property);
        $refl->setAccessible(true);
        
        $refl->setValue($object, $value);
    }

    /**
     * Get a private or protected property
     * @param  object $obj
     * @param  string $prop
     * @return mixed
     */
    protected function getPrivateProperty($obj, string $prop) {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);

        return $property->getValue($obj);
    }

    /**
     * Assert the last error
     * 
     * @param int    $type     Expected error type, E_* constant
     * @param string $message  Expected error message
     */
    protected function assertLastError(int $type, string $message = null)
    {
        $expected = compact('type') + (isset($message) ? compact('message') : []);
        $this->assertArraySubset($expected, error_get_last());
    }
    
    
    /**
     * Create mock for next callback.
     * 
     * <code>
     *   $callback = $this->createCallbackMock($this->once(), ['abc'], 10);
     * </code>
     * 
     * OR
     * 
     * <code>
     *   $callback = $this->createCallbackMock(
     *     $this->once(),
     *     function(PHPUnit_Framework_MockObject_InvocationMocker $invoke) {
     *       $invoke->with('abc')->willReturn(10);
     *     }
     *   );
     * </code>
     * 
     * @param Invocation          $matcher
     * @param \Closure|array|null $assert
     * @param mixed               $return
     * @return MockObject
     */
    protected function createCallbackMock(Invocation $matcher, $assert = null, $return = null): MockObject
    {
        if (isset($assert) && !is_array($assert) && !$assert instanceof \Closure) {
            $type = (is_object($assert) ? get_class($assert) . ' ' : '') . gettype($assert);
            throw new \InvalidArgumentException("Expected an array or Closure, got a $type");
        }
        
        $callback = $this->getMockBuilder(\stdClass::class)->setMethods(['__invoke'])->getMock();
        $invoke = $callback->expects($matcher)->method('__invoke');
        
        if ($assert instanceof \Closure) {
            $assert($invoke);
        } elseif (is_array($assert)) {
            $invoke->with(...$assert)->willReturn($return);
        }
        
        return $callback;
    }
}

