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

function search(){
    if( $('#txtSearch').val().length>0 ){
        location.href = baseURI+"search/index/keyword/"+$('#txtSearch').val();
    }
}

function show_error(el, msg, container){
    if( typeof container=="undefined" ) container=null;
    $.validator.show(el,{
        message : msg,
        container : container
    });
    try{el.focus();}
    catch(e){}
}