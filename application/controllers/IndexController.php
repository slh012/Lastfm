<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function testAction(){
        
    }
    
    public function indexAction()
    {
        // action body
        $api_key = Zend_Registry::get('lastfm_api_key');
              
        CallerFactory::getDefaultCaller()->setApiKey($api_key);
        
        
    
         if($this->getParam('username')){
                $lastUser = $this->getParam('username');
                $this->view->lastUser = $lastUser;
                
                // create the callback url
                $callback = "http://" . $_SERVER["HTTP_HOST"].'?username='.$lastUser ;
                $url = "http://www.last.fm/api/auth/?api_key=" . $api_key . "&cb=" . $callback;
                $this->view->authenticate = '<a href="' . $url . '"><span class="glyphicon glyphicon-asterisk"></span> Authenticate</a>';
                
                $userTracks = User::getRecentTracks($lastUser, 10);    
  
                $this->view->lastTrack = Model_lastfm_User::getLastTrack($userTracks);            

                $modelArtist = new Model_Lastfm_Artist($userTracks);                
                $map = LastfmExt_MapsFactory::build('Google');

                if($modelArtist)
                {
//                    $this->view->eventLocations = $map::eventLocations($modelArtist->getCoords());
//                    $this->view->artistList = $map::artistsList($modelArtist->getArtists());
//
//                    $this->view->artistImages = $map::artistImages($modelArtist->getImages());
                    
                    $this->view->events = $map::artistEvents($modelArtist->getEvents());

                }

                /*
                $friends = User::getFriends($lastUser);           
                if($friends)
                {
                    $this->view->friends = $friends;
                }


                // search for the Coldplay band
                $artistName = "Elbow";  


                $this->view->artistName = $artistName;
                $limit = 1;
                $results = Artist::search($artistName, $limit);

                $this->view->results = $results;

                $events = Artist::getEvents($artistName);
                if($events)
                {
                    $this->view->events = $events;
                }

                $tracks = Artist::getTopTracks($artistName);
                if($tracks)
                {
                    $this->view->tracks = $tracks;
                }

                $albumName = "The Seldom Seen Kid";
                $this->view->albumName = $albumName;
                $album = Album::getInfo($artistName, $albumName);
                if($album)
                {
                    $this->view->album = $album;
                }
                 */
         }//post
    }


}

