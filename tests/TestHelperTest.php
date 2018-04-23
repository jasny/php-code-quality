<?php

namespace Jasny;

use Jasny\TestHelper;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @covers Jasny\TestHelper
 */
class TestHelperTest extends TestCase
{
    use TestHelper;

    protected $object;
    
    public function setUp()
    {
        $this->object = new class {
            private $privateProp;
            protected $protectedProp;
            public $publicProp;
            
            private function privateMethod($whois = 'I am') { return "$whois private"; }
            protected function protectedMethod($whois = 'I am') { return "$whois protected"; }
            public function publicMethod($whois = 'I am') { return "$whois public"; }
        };
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
        $callback = $this->createCallbackMock($this->any());
        
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
        } catch (ExpectationFailedException $e) {
            $this->forgetMockObjects();
        }
    }
    
    public function testCreateCallbackMockSimpleAssertInvoke()
    {
        $callback = $this->createCallbackMock($this->once(), ['foo', 'zoo'], 'bar');
        
        $this->assertTrue(is_callable($callback));
        
        $this->assertEquals('bar', $callback('foo', 'zoo'));
    }
    
    public function testCreateCallbackMockSimpleAssertInvokeFail()
    {
        $callback = $this->createCallbackMock($this->once(), ['foo'], 'bar');
        
        $this->assertTrue(is_callable($callback));
        
        try {
            $callback('qux');
            $this->fail("Expected an expectation failed exception");
        } catch (ExpectationFailedException $e) {
            $this->forgetMockObjects();
        }
    }
    
    public function testCreateCallbackMockAssertInvoke()
    {
        $callback = $this->createCallbackMock($this->once(), function(InvocationMocker $invoke) {
            $invoke->with('foo', 'zoo')->willReturn('bar');
        });
        
        $this->assertTrue(is_callable($callback));
        
        $this->assertEquals('bar', $callback('foo', 'zoo'));
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
        } catch (ExpectationFailedException $e) {
            $this->forgetMockObjects();
        }
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateCallbackMockInvalidAssert()
    {
        $this->createCallbackMock($this->once(), 'foo');
    }
}

