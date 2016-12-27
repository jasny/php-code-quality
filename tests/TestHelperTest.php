<?php

namespace Jasny;

use Jasny\TestHelper;
use Jasny\TestHelperSupportClass;
use PHPUnit_Framework_TestCase as TestCase;

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
}
