<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of artistController
 *
 * @author Sean
 */
class EventController  extends Zend_Controller_Action
{
     public function indexAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->isGet()){
            
            // action body
            $api_key = Zend_Registry::get('lastfm_api_key');

            CallerFactory::getDefaultCaller()->setApiKey($api_key);
            
            $artistName = $this->getParam('artist');
            $eventId = $this->getParam('eventId');
            $username = $this->getParam('username');
            
            $userEvents = User::getEvents($username);
            
            $output['attending'] = Model_Lastfm_Event::checkAttending($userEvents, $eventId);
                
                    
            $event = Event::getInfo($eventId);
            $output['image'] = $event->getImage(2);
            $output['venueName'] = $event->getVenue()->getName();
            $output['venueCity'] = $event->getVenue()->getLocation()->getCity();
            $output['venueUrl'] = $event->getVenue()->getUrl();//not always available
            $output['date'] = date('D, jS F Y',$event->getStartDate());
            
            echo json_encode($output);
        }
     }
     
     public function attendAction()
     {
         $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
         // action body
            $api_key = Zend_Registry::get('lastfm_api_key');

            CallerFactory::getDefaultCaller()->setApiKey($api_key);
            
            if($this->getRequest()->isGet())
            {
                $eventId = $this->getParam('eventId');
                $status = $this->getParam('status');
                //The attendance status (0=Attending, 1=Maybe attending, 2=Not attending)
                $token = $this->getParam('token');
                CallerFactory::getCurlCaller()->setApiSecret('d0857d1ecd24661a46ac10005a3930cc');
                $session = Auth::getSession($token);                  
                
                $res = Event::attend($eventId, $status, $session);
                if($res == 'ok')
                {
                 echo '{ "result":"success" }';   
                 exit();
                }
            }
            
     }
}
