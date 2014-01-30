<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Track
 *
 * @author Sean
 */
class LastfmExt_Track extends Track
{
    
    /** TCurrenly playing track.
    *
    * @var boolean
    * @access	private
    */
    private $nowPlaying;
    
    public function __construct($artist, $album, $name, $mbid, $url,
								array $images, $listeners, $playCount,
								$duration, array $topTags, $id, $location,
								$streamable, $fullTrack, $wiki, $lastPlayed, $nowPlaying){
		parent::__construct($name, $mbid, $url, $images, $listeners, $playCount);

		$this->artist     = $artist;
		$this->album      = $album;
		$this->duration   = $duration;
		$this->topTags    = $topTags;
		$this->id         = $id;
		$this->location   = $location;
		$this->streamable = $streamable;
		$this->fullTrack  = $fullTrack;
		$this->wiki       = $wiki;
		$this->lastPlayed = $lastPlayed;
                $this->nowPlaying = $nowPlaying;
	}
    
    /** Create a Track object from a SimpleXMLElement.
	 *
	 * @param	SimpleXMLElement	$xml	A SimpleXMLElement.
	 * @return	Track						A Track object.
	 *
	 * @static
	 * @access	public
	 * @internal
	 */
	public static function fromSimpleXMLElement(SimpleXMLElement $xml)
        {
            $images  = array(); 
            $topTags = array();

            if($xml->nowplaying){                    
               $nowplaying = $xml->nowplaying;
            }else{
                $nowplaying = 'false';
            }
            
            if(count($xml->image) > 1){
                    foreach($xml->image as $image){
                            $images[Util::toImageType($image['size'])] = Util::toString($image);
                    }
            }
            else{
                    $images[Media::IMAGE_UNKNOWN] = Util::toString($xml->image);
            }

            if($xml->toptags){
                    foreach($xml->toptags->children() as $tag){
                            $topTags[] = Tag::fromSimpleXMLElement($tag);
                    }
            }

            if($xml->artist){
                    if($xml->artist->name && $xml->artist->mbid && $xml->artist->url){
                            $artist = new Artist(
                                    Util::toString($xml->artist->name),
                                    Util::toString($xml->artist->mbid),
                                    Util::toString($xml->artist->url),
                                    array(), 0, 0, 0, array(), array(), '', 0.0
                            );
                    }
                    else{
                            $artist = Util::toString($xml->artist);
                    }
            }
            else if($xml->creator){
                    $artist = Util::toString($xml->creator);
            }
            else{
                    $artist = '';
            }

            if($xml->name){
                    $name = Util::toString($xml->name);
            }
            else if($xml->title){
                    $name = Util::toString($xml->title);
            }
            else{
                    $name = '';
            }

            // TODO: <extension application="http://www.last.fm">

            return new Track(
                    $artist,
                    Util::toString($xml->album),
                    $name,
                    Util::toString($xml->mbid),
                    Util::toString($xml->url),
                    $images,
                    Util::toInteger($xml->listeners),
                    Util::toInteger($xml->playcount),
                    Util::toInteger($xml->duration),
                    $topTags,
                    Util::toInteger($xml->id),
                    Util::toString($xml->location),
                    Util::toBoolean($xml->streamable),
                    Util::toBoolean($xml->streamable['fulltrack']),
                    $xml->wiki, // TODO: Wiki object
                    Util::toTimestamp($xml->date),
                    $nowplaying
            );
    }
}
