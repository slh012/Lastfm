<?php

/**
 * Description of MapsInterface
 *
 * @author Sean
 */
interface LastfmExt_MapsInterface
{
    
    public static function artistEvents($events);
    
    public static function artistsList($artists);
    
    public static function eventLocations($coords);
    
    public static function artistImages($images);
}
