<?php


/**
 * Description of MapsFactory
 *
 * @author Sean
 */
class LastfmExt_MapsFactory
{
    static $nameSpace = 'Model_Lastfm_Maps_';
    
    public static function build($class)
    {
         // assumes the use of an autoloader
        $fullClassName = self::$nameSpace.$class;
        if (class_exists($fullClassName)) {
            return new $fullClassName();
        }
        else {
            throw new Exception("Invalid map type given.");
        }
        
    }
}
