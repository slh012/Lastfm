<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author Sean
 */
class Model_Lastfm_Event
{
    public static function checkAttending($userEvents, $eventId)
    {
        foreach($userEvents as $event)
        {
            
            if($event->getId() == $eventId)
            {                
                return true;
            }
        }
        
        return false;
    }
}
