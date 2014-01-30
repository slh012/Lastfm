"use strict";
var require;

require.config({
    paths:{       
        "jquery":"vendor/jquery/jquery",
        "underscore":"vendor/underscore-amd/underscore",
        "backbone":"vendor/backbone-amd/backbone",
        "bootstrap":"vendor/bootstrap/dist/js/bootstrap",
        "bootbox":"vendor/bootbox/bootbox",
        "map":"googleMapsEvents",
        "utils":"utils"
    }
});

require(["utils","jquery","bootstrap","bootbox","map"], function(utils, $, bootstrap, bb, map){ 
    
  
      
    if($.urlParam('username')==null){
        google.maps.event.addDomListener(window, 'load', map.init([])); 
    }
    else if(events.length){
    
        google.maps.event.addDomListener(window, 'load', map.init(events));  

        $('#mapArtistsList li input').change(function(){

            if($(this).attr('checked')=='checked')
            {            
                //is now checked
                map.addMarker($(this));
                $(this).attr("checked", true);
            }else{
                //is now unchecked
                map.removeMarker($(this));
                $(this).attr("checked", false);
            }
        })
    }else{
      
       google.maps.event.addDomListener(window, 'load', map.init([])); 
       bootbox.alert("There are no events for the tracks listened to.");
         
        
    }
});
require(["jquery", "bootstrap"], function(){ });

require(["jquery"], function($) {
    
    $(document).ready( function() {
	  
	});
});
