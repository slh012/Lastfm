<?php

/**
 * Description of ControllerTestCase
 *
 * @author Sean
 */
class ControllerTestCase 
    extends Zend_Test_PHPUnit_ControllerTestCase
{
    //put your code here
    /**
     * @var Zend_Application
     */
    
    protected $application;
    
    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }
    
    public function appBootstrap()
    {
        
        $this->application = new Zend_Application(APPLICATION_ENV,             
                                                  APPLICATION_PATH . '/configs/application.ini');
        
        $this->application->bootstrap();
    }
}
