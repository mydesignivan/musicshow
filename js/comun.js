function load_combo(url, el, id, callback){
    el.disabled = true;
    if( url.substr(url.length-1)!="/" ) url+="/";
    $.get(baseURI+url+el.value,'', function(data){
        $('#'+id).empty()
                 .append(data);

        el.disabled = false;
        if( typeof callback=="function" ) callback();
    });
}
