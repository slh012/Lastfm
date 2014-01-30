function getDomain(){
    var temp = window.location.href.split("/");
    var domain   
    domain = temp[2];
    return domain;
}
function parseJson(json){
    return $.parseJSON(json);
}
$.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}