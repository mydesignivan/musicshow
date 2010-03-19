function open_popup(url){
    popup = $('#popup');
    $.get(url, '', function(data){
        popup.find('.middle').html(data);
    });
    popup.css({
        'left' : (($(window).width()/2)-(popup.width()/2))+"px",
        'top'  : (($(window).height()/2)-(popup.height()/2))+"px"
    }).show();

    $(document.body).keypress(function(e){
        if( e.keyCode==27 ) close_popup();
    });
}

function close_popup(){
    $('#popup').fadeOut(300, function(){
        $(this).find('.middle').empty();
        $('#mask').hide();
    });
}

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
