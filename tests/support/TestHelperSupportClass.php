<?php

namespace Jasny;

/**
 * Class for testing TestHelper trait
 */
class TestHelperSupportClass
{
    /**
     * A private property
     * 
     * @var mixed
     */
    private $privateProp;
    
    /**
     * A protected property
     * 
     * @var mixed
     */
    protected $protectedProp;
    
    /**
     * A private property
     * 
     * @var mixed
     */
    public $publicProp;
    
    
    /**
     * A private method
     * 
     * @return string
     */
    private function privateMethod($whois = 'I am')
    {
        return "$whois private";
    }
    
    /**
     * A protected method
     * 
     * @return string
     */
    protected function protectedMethod($whois = 'I am')
    {
        return "$whois protected";
    }
    
    /**
     * A public method
     * 
     * @return string
     */
    public function publicMethod($whois = 'I am')
    {
        return "$whois public";
    }
}
