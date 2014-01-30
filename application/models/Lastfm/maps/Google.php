<?php


/**
 * Description of GoogleMaps
 *
 * @author Sean
 */
class Model_Lastfm_Maps_Google implements LastfmExt_MapsInterface
{
    public function __construct()
    {
        //
    }
    
    public static function artistEvents($events)
    {
        if(!is_array($events) || empty($events))
            return false;
        
         $json = 'var events = [';
        $i=0;
        foreach($events as $eventId => $array)
        {          
              $json .= "\n{";
            foreach($array as $key => $val){    
                $json .= "\n\"{$key}\":\"{$val}\",";                
            }
            $json = rtrim($json, ',');  
            $json .= '},';
           $i++;
        }       
        $json = rtrim($json, ',');        
        $json .= '];';
        return $json;
    }
    
    public static function artistImages($images)
    {
       
        if(!is_array($images) || empty($images))
            return false;
       // print "<pre>";
        $json = 'var artistImages = {';
        
        foreach($images as $artist => $array)
        {
              $json .= "\n\"{$artist}\":[{";
            foreach($array as $size => $image){              
                $json .= "\n\"{$size}\":\"{$image}\",";
            }
            $json = rtrim($json, ',');  
            $json .= '}],';
            
        }
        $json = rtrim($json, ',');        
        $json .= '};';
        return $json;
    }


    public static function artistsList($artists)
    {
        if(!is_array($artists) || empty($artists))
            return false;
        
        $list = '<ul id="mapArtistsList" class="list-unstyled">';
        
        foreach($artists as $key => $artist)
        {            
            $artistId = str_replace(' ','',$artist);
            $list .= "\n<li><input type=\"checkbox\" checked=\"checked\" data-artist=\"{$artist}\" class=\"artistCheck\" id=\"artist{$artistId}\">&nbsp; {$artist}</li>";
        }        
        $list .= '</ul>';
        return $list;
    }
    
    public static function eventLocations($coords)
    {
        $locations = 'var eventLocations = [';
        
        if(!is_array($coords) || empty($coords)){
             $locations .= '];';
            return $locations;
        }  
        foreach($coords as $id => $array){
            foreach($array as $place => $coord)
            {
                list($lat, $lon) = explode(',', $coord);
                $locations .= "\n['{$place}', {$lat}, {$lon}, {$id}],";
            }
        }
        $locations = rtrim($locations, ',');        
        $locations .= '];';
        return $locations;
    }
}
