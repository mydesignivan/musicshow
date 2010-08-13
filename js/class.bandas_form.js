var Bandas = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(_params){
        params.mode = _params;

        var o = $.extend(true, {
            //debug : true,
            rules : {
                txtBanda        : 'required',
                txtGenero       : 'required',
                cboStates       : 'required',
                cboCity         : 'required',
                txtInfluencias  : 'required'
            },

            submitHandler : function(){
                //ajaxloader.show('Validando Formulario');
            },

            invalidHandler : function(){
                //ajaxloader.hidden();
            },
            onsubmit : false

        }, jQueryValidatorOptDef);
        $('#form1').bind('submit', _on_submit).validate(o);

        popup.initializer();

        JTable.init('#tblDiscografica');

        formatNumber.init('#txtTocandoDesde, .jq-field-int');

    };

    this.save = function(){
        /*if( working ) return false;
        
        if( $('#form1')[0].optDiscografia[0].value==1 ){
            var arr_tracks = new Array();
            $('#tblDiscografica tbody tbody tr').each(function(){
                var input = $(this).find('input:text');
                arr_tracks.push({
                    name    : input.eq(0).val(),
                    minutes : input.eq(1).val()
                });                
            });
            $('#extra_post').val(JSON.encode(arr_tracks));
        }

        ajaxloader.show('Validando Formulario');
        $.validator.validate('#form1 .validate', function(error){
            if( !error && valid_integrantes() && valid_images() ){
                ajaxloader.show('Enviando Formulario');

                //$('#form1').submit();

            }else{
                ajaxloader.hidden();
            }
        });

        return false;*/
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

    this.attach_file = function(){
        var ul = $('#contImages');
        var nli = ul.find('li:first').clone();
        nli.find('li');
        nli.find('input').val('');
        ul.append(nli);
    };

    this.attach_file_remove = function(el){
        if( $('#contImages li').length>1 ) {
            if( confirm('¿Confirma eliminar?') ){
                $(el).parent().parent().remove();
            }
        }
    };

    this.change_bandaweb = function(el){
        if( el.value=="other" ) $(el).parent().find('input').val('').show().focus();
        else $(el).parent().find('input').hide();
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var params={};

    /* PRIVATE METHODS
     **************************************************************************/
    var _on_submit = function(){
        if( working ) return false;

        if( $('#form1').valid() && _valid_integrantes() && _valid_images() ){
            ajaxloader.show('Enviando Formulario');
            
            if( $('#form1')[0].optDiscografia[0].value==1 ){
                var arr_tracks = new Array();
                $('#tblDiscografica tbody tbody tr').each(function(){
                    var input = $(this).find('input:text');
                    arr_tracks.push({
                        name    : input.eq(0).val(),
                        minutes : input.eq(1).val()
                    });
                });
                $('#extra_post').val(JSON.encode(arr_tracks));
            }
            
            return true;

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
        var inputs = $('#contImages input:file');
        var empty=0;

        inputs.each(function(){
            if( !$(this).val() ) empty++;
        });

        if( empty == inputs.length ){
            $('#msgbox-image').html("Este campo es obligatorio.").show().focus();
            return false;
        }else $('#msgbox-image').hide();

        return true;
    };

})();