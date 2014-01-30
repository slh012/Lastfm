/*!
 * googleMapsEvents JavaScript Library v0.0.1
 *
 * Date: 
 */
define([], function(){
 
 var markers = new Array();
 var directionsDisplay;
 var directionsService = new google.maps.DirectionsService();
 var map;
// Setup the different icons and shadows
var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';

var shadow = {};
var infowindow = {};

var this_events;
var userLocation;
var that;
var attendingGoing = 'This gig sucks. I don\'t wanna go no more.';
var attendingNotSpecified = 'Go to this gig. You know you want to.';

function calcRoute(end) {
    $('.eventDirections').click(function(e){
        e.preventDefault();
        var request = {
            origin:userLocation,
            destination:end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        
        that = $(this);
        
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            // console.log(response);

            that.after('<br/>'+response.routes[0].legs[0].distance.text+'<br/>'+response.routes[0].legs[0].duration.text);
           
          }
        });
    });
}

function attendEvent(eventId, status){   
    
    //add event
    $('.eventAttend').click(function(e){
        that = $(this);
        e.preventDefault();
        $.ajax({
            type: "GET",                
            url: 'http://'+getDomain()+'/event/attend/',                
            data: ({token:$.urlParam('token'), eventId:eventId, status:$(this).data('status')}),
             success: function(result){
                var res = parseJson(result);
                if(res.result == 'success'){
                    bootbox.alert("Attending gig!");
                    var status = that.data('status');
                   
                    if(status == 0){                        
                        that.data('status', 2);
                        that.html(attendingGoing);
                    }else{
                        that.data('status', 0);
                        that.html(attendingNotSpecified);
                    }      
                  
                }else{
                    bootbox.alert("Error");
                }
            }
        });	
    });
}
function loadInfoWindow(infowindow, marker, artist, eventId){   
    //add event
   // console.log(artist);
   //  console.log(eventId);
    $.ajax({
        type: "GET",                
        url: 'http://'+getDomain()+'/event/',                
        data: ({artist:artist, eventId:eventId, username:$.urlParam('username')}),
         success: function(result){
           var res = parseJson(result);
           var attendingStatus;
           if(res.attending === true)
           {
               attendingStatus = '<a href="#" class="eventAttend" data-status="2">'+attendingGoing+'</a>';
           }else{
               attendingStatus = '<a href="#" class="eventAttend" data-status="0">'+attendingNotSpecified+'</a>';
           }
           
           infowindow.setContent('<strong>'+artist+'</strong><br/><em>'+res.venueName+'<br/>'+res.venueCity+'</em><br/>'+res.date+'<img src="'+res.image+'"/><br/>'+attendingStatus+'<br/><a href="#" class="eventDirections">Directions</a>');
           infowindow.open(map, marker);
           attendEvent(eventId);
          
           calcRoute(res.venueCity);
        }
    });	
}
function setMarker(i, lat, long, artist, image){

     var  marker = new google.maps.Marker({              
            position: new google.maps.LatLng(lat, long),
            map: map,
            icon : image,
            shadow: shadow
        });
     markers.push(marker);
 
     return marker;
   
}

function addEvent(i, marker, artist, eventId){

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  loadInfoWindow(infowindow, marker, artist, eventId);                  
                }
              })(marker, i));
}

 function googleMapsYourLocationMap (position)
 {        

     userLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
     
     var marker = new google.maps.Marker({  
        map: map,  
        position: userLocation,  
        animation: google.maps.Animation.DROP,  
        title: "This is your location",
        shadow: shadow,
        icon : '/img/icons/maps/bighouse.png'//http://mapicons.nicolasmollet.com
        
    });  
    map.setCenter(userLocation);  
}
 
 

    function showError () {
       alert("Location can't be found");  
    }
   
       function setUserLocation  () {                   
                   
                    if (navigator.geolocation) {  
                        navigator.geolocation.getCurrentPosition(googleMapsYourLocationMap, showError);  
                    }  
                    else {  
                        alert("Your browser does not support Geolocation.");  
                    } 

                  }
        function setupMap(){
            
            directionsDisplay = new google.maps.DirectionsRenderer();
            
             var mapOptions = {         
                zoom: 6
              };
              
              map = new google.maps.Map(document.getElementById("map-canvas"),
                  mapOptions);


              shadow = {
                anchor: new google.maps.Point(15,33),
                url: iconURLPrefix + 'msmarker.shadow.png'
              };    

              infowindow = new google.maps.InfoWindow({
                maxWidth: 160
              });
              
              
             
            var marker;
             

            for(var i = 0; i < this_events.length; i++) {
                var obj = this_events[i];
                marker = setMarker(i, obj.lat, obj.long, obj.artist, obj.image);
                addEvent(i, marker, obj.artist, obj.eventId);               
            }
            
             directionsDisplay.setMap(map);

        }
        return {
            init : function (events){
             
                                         
              this_events = events;
             
             
              setUserLocation();
              
              setupMap();
              
            },
             oldLocations : function (){
                return oldLocations;
            },
            map : function (){
                return map;
            },
            markers : function (){
                return markers;
            },
                
                  addMarker: function (that)
                  {
                      var artist = that.data('artist');
                   
                                      
                                           
                        for(var i = 0; i < this_events.length; i++) {
                             var obj = this_events[i];
                           //var checked = $('.artistCheck#'+obj.artist).attr("checked");
                            if(artist==obj.artist){                               
                                marker = setMarker(i, obj.lat, obj.long, obj.artist, obj.image);
                                addEvent(i, marker, obj.artist, obj.eventId);               
                            }
                        }
                        
                  },
            
         removeMarker: function  (that)
        {
            var artist = that.data('artist');
         
           
            
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
              }
           
           
           
           
            var checked; 
            var artistId;
            for(var i = 0; i < this_events.length; i++) {
                 var obj = this_events[i];
                 artistId = obj.artist.replace(' ','');
                 checked = $('#artist'+artistId+'.artistCheck').attr("checked");
                 
                 if(checked=='checked'){                      
                     marker = setMarker(i, obj.lat, obj.long, obj.artist, obj.image);
                     addEvent(i, marker, obj.artist, obj.eventId);               
                 }
             }
            
            
           
            
        }
  }//return    
});//define
   