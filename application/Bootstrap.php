<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
     protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
       
    } 
    
    protected function _initAutoload()
    {
       
        $moduleLoad = new Zend_Application_Module_Autoloader(array(
           'namespace' => '',
           'basePath'   => APPLICATION_PATH
        ));
        
        require APPLICATION_PATH.'\..\library\Lastfm\src\lastfm.api.php';
        
        /*
        * Automatically set the javascript files to their min counterparts when not in DEV mode
        */
        $this->view->minjs = (APPLICATION_ENV == 'production')? '.min':'';
       
        
        
    }
    
    public function _initLastfm()
    {
        $lastfmConfig = $this->getOption('lastfm');//get from app.ini               
        Zend_Registry::set('lastfm_api_key', $lastfmConfig['api_key']);      
        
        
    }

}