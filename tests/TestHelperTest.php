<?php

namespace Jasny;

use Jasny\TestHelper;
use Jasny\TestHelperSupportClass;
use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_Builder_InvocationMocker as InvocationMocker;

/**
 * @covers Jasny\TestHelper
 */
class TestHelperTest extends TestCase
{
    use TestHelper;
    
    /**
     * @var TestHelperSupportClass
     */
    protected $object;
    
    public function setUp()
    {
        $this->object = new TestHelperSupportClass();
    }
    
    protected function forgetMockObjects()
    {
        $refl = new \ReflectionProperty(TestCase::class, 'mockObjects');
        $refl->setAccessible(true);
        
        $refl->setValue($this, []);
    }
    
    
    public function accessProvider()
    {
        return [
            ['private'],
            ['protected'],
            ['public']
        ];
    }
    
    
    /**
     * @dataProvider accessProvider
     * @param string $access
     */
    public function testCallPrivateMethod($access)
    {
        $result = $this->callPrivateMethod($this->object, $access . 'Method');
        
        $this->assertEquals("I am $access", $result);
    }
    
    /**
     * @dataProvider accessProvider
     * @param string $access
     */
    public function testCallPrivateMethodWithArgument($access)
    {
        $result = $this->callPrivateMethod($this->object, $access . 'Method', ['You are']);
        
        $this->assertEquals("You are $access", $result);
    }
    
    
    /**
     * @dataProvider accessProvider
     * @param string $access
     */
    public function testSetPrivateProperty($access)
    {
        $this->setPrivateProperty($this->object, $access . 'Prop', 'foo');
        
        $this->assertAttributeEquals('foo', $access . 'Prop', $this->object);
    }
    
    
    public function errorLevelProvider()
    {
        return [
            [E_USER_NOTICE],
            [E_USER_WARNING]
        ];
    }
    
    /**
     * @dataProvider errorLevelProvider
     * @param int $level
     */
    public function testAssertLastError($level)
    {
        @trigger_error("Some error", $level);
        
        $this->assertLastError($level, "Some error");
    }
    
    
    public function testCreateCallbackMock()
    {
        $callback = $this->createCallbackMock();
        
        $this->assertTrue(is_callable($callback));
        
        $this->assertNull($callback('foo'));
        $this->assertNull($callback('bar'));
        $this->assertNull($callback('zoo'));
    }
    
    public function testCreateCallbackMockNeverInvoke()
    {
        $callback = $this->createCallbackMock($this->never());
        
        $this->assertTrue(is_callable($callback));
        
        try {
            $callback();
            $this->fail("Expected an expectation failed exception");
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $this->forgetMockObjects();
        }
    }
    
    public function testCreateCallbackMockAssertInvoke()
    {
        $callback = $this->createCallbackMock($this->once(), function(InvocationMocker $invoke) {
            $invoke->with('foo')->willReturn('bar');
        });
        
        $this->assertTrue(is_callable($callback));
        
        $this->assertEquals('bar', $callback('foo'));
    }
    
    public function testCreateCallbackMockAssertInvokeFail()
    {
        $callback = $this->createCallbackMock($this->once(), function(InvocationMocker $invoke) {
            $invoke->with('foo');
        });
        
        $this->assertTrue(is_callable($callback));
        
        try {
            $callback('qux');
            $this->fail("Expected an expectation failed exception");
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $this->forgetMockObjects();
        }
    }
}
