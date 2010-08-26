var Bandas = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(params){
        _params = params;

        var o = $.extend(true, {
            //debug : true,
            rules : {
                txtBanda        : 'required',
                txtGenero       : 'required',
                cboStates       : 'required',
                cboCity         : 'required'
            },
            invalidHandler : function(){
                ajaxloader.hidden();
            },
            onsubmit : false

        }, jQueryValidatorOptDef);
        $('#form1').bind('submit', _on_submit).validate(o);

        popup.initializer();

        JTable.init('#tblImagesBandas', function(tr){
            tr.find('td a.jq-thumb').remove();
        });
        JTable.init('#tblDiscografica, #tblImagesBandas', function(tr){
            tr.find('td a.jq-thumb').remove();
            tr.find('tbody tr').each(function(i){
                if( i>0 ) $(this).remove();
            });
        });

        formatNumber.init('#txtTocandoDesde, .jq-field-int');

        $('a.jq-thumb').fancybox();
    };

    this.show_states = function(el){
        if( el.value!=0 ){
            el.disbled=true;
            $.post(baseURI+'paneluser/bandas/ajax_show_states', 'id='+el.value, function(data){
                el.disbled=false;
                $('#cboCity').html(data);
            });
        }
    };

    this.removeImage = function(t){
        var tr = $(t).parent().parent();
        var id = tr.attr('id').substr(5);
        if( !isNaN(id) ) {
            var tagA = tr.find('a.jq-thumb');
            var tagImg = tagA.find('img');
        }

        JTable.remove(t, function(){
            if( !isNaN(id) ) {
                imgDel.push(id);
                imgHref.image.push(tagA.attr('href'));
                imgHref.thumb.push(tagImg.attr('src'));
            }
        });
    };

    this.addImage = function(){
        JTable.add('#tblImagesBandas', function(tr){
            tr.removeAttr('id');
            tr.find('input:file').attr('name', 'txtImage[]');
            tr.find('textarea').attr('name', 'txtImageComment[]');
            tr.find('input[type=hidden]').remove();
        });
    };

    this.removeDisc = function(t){
        var tr = $(t).parent().parent();
        var id = tr.attr('id').substr(4);

        if( !isNaN(id) ) {
            var tagA = tr.find('a.jq-thumb');
            var tagImg = tagA.find('img');
        }

        JTable.remove(t, function(){
            if( !isNaN(id) ) {
                discDel.push(id);
                discHref.image.push(tagA.attr('href'));
                discHref.thumb.push(tagImg.attr('src'));
            }
        });
    };

    this.addDisc = function(){
        JTable.add('#tblDiscografica', function(tr){
            tr.removeAttr('id');
            tr.find('input').each(function(){
                $(this).attr('name', $(this).attr('name').replace('Edit', ''));
            });
            tr.find('input[type=hidden]').remove();
        });
    };

    this.change_bandaweb = function(el){
        if( el.value=="other" ) $(el).parent().find('input').val('').show().focus();
        else $(el).parent().find('input').hide();
    };

    this.showhide_discografica = function(a){
        if( a=="show" ){
            $('#div1').fadeIn('slow');
            $('#txtDiscActual').focus();
        }else{
            $('#div1').fadeOut('slow');
            $('#txtDiscActual').val('');
        }
    };

    this.showhide_manager = function(a){
        if( a=="show" ){
            $('#contManager').fadeIn('slow');
            $('#txtManagerName').focus();

        }else{
            $('#contManager').fadeOut('slow');
            $('#txtManagerName, #txtManagerPhone, #txtManagerEmail').val('');
        }
    };

    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var _params={};
    var imgDel = [];
    var imgHref = {
        image : [],
        thumb : []
    };
    var discDel = [];
    var discHref = {
        image : [],
        thumb : []
    };

    /* PRIVATE METHODS
     **************************************************************************/
    var _on_submit = function(){
        if( working ) return false;
        ajaxloader.show('Validando Formulario');

        if( $('#form1').valid() && _valid_integrantes() && _valid_images() ){
            ajaxloader.show('Enviando Formulario');

            var json={};

            var arr_tracks = [];

            if( _params.mode=="edit" ){
                var arr_tracks_edit = [];
                json.imagedisc_del = discDel;
                json.imagedisc_href = discHref;
                json.href_imgdisc_image = [];
                json.href_imgdisc_thumb = [];
                json.discografica_id = [];
            }

            $('#tblDiscografica >tbody >tr').each(function(){
                var arr = [];
                var input;
                var t=$(this);

                t.find('tbody tr').each(function(){
                    input = $(this).find('input:text');
                    arr.push({
                        name    : input.eq(0).val(),
                        minutes : input.eq(1).val()
                    });
                });

                if( t.attr('id')=='' ){
                    arr_tracks.push(arr);
                }else{
                    arr_tracks_edit.push(arr);
                    input = t.find('input:file');
                    if( t.find('input:file').val() ){
                        var a = t.find('.jq-thumb');
                        json.href_imgdisc_image.push( a.attr('href') );
                        json.href_imgdisc_thumb.push( a.find('img').attr('src') );
                        json.discografica_id.push( t.attr('id').substr(4) );
                    }

                }
            });
            json.tracks = arr_tracks;
            json.tracks_edit = arr_tracks_edit;


            if( _params.mode=="edit" ){
                json.image_del = imgDel;
                json.image_href = imgHref;
                json.href_imgbanda_image = [];
                json.href_imgbanda_thumb = [];
                json.bandagallerie_id = [];

                //Extrae los href de las imagenes que se editaron
                $('#tblImagesBandas input:file').each(function(){
                    var t=$(this);
                    if( t.val() && t.parent().parent().attr('id')!='' ){

                        json.href_imgbanda_image.push( t.parent().find('a').attr('href') );
                        json.href_imgbanda_thumb.push( t.parent().find('img').attr('src') );
                        json.bandagallerie_id.push( t.parent().parent().attr('id').substr(5) );

                    }
                });
            }

            $('#extra_post').val(JSON.encode(json));

            return true;
        }else{
            ajaxloader.hidden();
            alert("Comprube los campos obligatorios.")
        }

        return false;
    };

    var ajaxloader ={
        show : function(msg){
            var html = '<div class="text-center">';
                html+= '<p>'+msg+'</p>';
                html+= '<img src="images/ajax-loader.gif" alt="" />';
                html+= '</div>';

            popup.load({html : html}, {
                reload  : true,
                bloqEsc : true,
                effectClose : false
            });
            working=true;
        },
        hidden : function(){
            popup.close();
            working=false;
        }
    };

    var _valid_integrantes = function() {
        var empty=0;
        var inputs = $('#tblIntegrantes tbody tr input:text');
        inputs.each(function(){
            if( !$(this).val() ) empty++;
        });

        if( empty == inputs.length ){
            $('#msgbox-integrantes').html("Se requiere que ingrese al menos un integrante.").show().focus();
            return false;

        }else $('#msgbox-integrantes').hide();

        return true;
    };

    var _valid_images = function(){
        var empty=0;
        var condition=false;

        var inputs = $('#tblImagesBandas tbody input:file');
        inputs.each(function(){
            if( !$(this).val() ) empty++;
        });
        condition = _params.mode=="create" ? empty == inputs.length : $('#tblImagesBandas tbody img').length==0 && empty == inputs.length;
        if( condition ){
            $('#msgbox-image').html("Este campo es obligatorio.").show().focus();
            return false;
        }else $('#msgbox-image').hide();

        return true;
    };

})();