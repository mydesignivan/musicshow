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