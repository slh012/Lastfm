<?php

class Model_Lastfm_Artist
{
    
    /**
     *
     * @var array 
     */
    protected $_events;
    /**
     *
     * @var array
     */
    protected $_lat;
    /**
     *
     * @var array 
     */
    protected $_long;
    
    /**
     *
     * @var array 
     */
    protected $_coords;
    
    /**
     *
     * @var array 
     */
    protected $_artists = array();
    
    /**
     *
     * @var string 
     */
    protected $_images;
    
    /**
     *
     * @var array 
     */
    protected $_errors;
    
    
    public function __construct(array $userTracks)
    {
        if(empty($userTracks))
        {
            $this->_errors = 'Array of tracks is empty';
            return false;
        }
    //    print "<pre>";
//        print_r($userTracks);
//        exit();
     
        foreach($userTracks as $key => $tracks)
        {

           
            $artistName = $tracks->getArtist();            
            $events = Artist::getEvents($artistName);
            
          
            foreach($events as $key => $event)
            {
                
                $lat = $event->getVenue()->getLocation()->getPoint()->getLatitude();
                $long = $event->getVenue()->getLocation()->getPoint()->getLongitude();
                
                if($lat > 0 && $long > 0 )
                {
                    
                    $track = $tracks->getName();


                    $this->_images[$artistName]['small'] = $event->getImage(0);
                    $this->_images[$artistName]['medium'] = $event->getImage(1);
                    $this->_images[$artistName]['large'] = $event->getImage(2);

                    if(!array_key_exists($artistName, $this->_artists))
                    {
                        $this->_artists[$artistName] = $artistName;     
                    }

                    
                
                
                    $this->_lat[$key] = $lat;
                    $this->_long[$key] = $long;
                    
                    $eventId= $event->getId();             
                    $this->_events[$eventId]['artist'] = $artistName;
                    $this->_events[$eventId]['lat'] = $lat;
                    $this->_events[$eventId]['long'] = $long;
                    $this->_events[$eventId]['eventId'] = $eventId;  
                    $this->_events[$eventId]['image'] = $event->getImage(0);
                    
                    $this->_coords[$event->getId()][$artistName] = $lat.','.$long;// add the city later with additional array of data for the marker.'<br />'.$event->getVenue()->getLocation()->getCity()
                }
            }
        }
    }
    
    public function getImages()
    {
        return $this->_images;       
    }
    
    public function getArtists()
    {
        return $this->_artists;       
    }
    
    public function getEvents()
    {                
        return $this->_events;            
    }
    
    public function getCoords()
    {                
        return $this->_coords;            
    }
    
}
