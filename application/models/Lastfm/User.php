<?php


/**
 * Description of User
 *
 * @author Sean
 */
class Model_lastfm_User
{
    
    public static function getLastTrack($userTracks)
    {
        //ideally I would like to use attribute 'nowplaying' as per http://www.last.fm/api/show/user.getRecentTracks
        //however it isn't always available and I've not been able to establish why.
        //just use the first object in the array for now
        return $userTracks[0];
    }
}
