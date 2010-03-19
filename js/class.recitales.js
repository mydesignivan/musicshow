/* 
 * Clase Recitales
 *
 * Llamada por las vistas: paneluser_recitales_view, paneluser_recitalesform_view
 * Su funcion: Crear, Modificar o Eliminar recitales
 *
 */

var Recitales = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(){
        f = $('#form1')[0];
        if( typeof f!="undefined" ){
            $.validator.setting('#form1 .validate', {
                effect_show     : 'slidefade',
                validateOne     : true
            });

            $('#txtBanda, #cboGenero, #txtPlace, #txtPlace2, #txtPrice').validator({
                v_required  : true
            });

            $('#txtDate').datepicker({
                dateFormat : 'dd/mm/yy',
                onClose : function(value){
                    validDate();
                }
            });

            $('#mask').css('opacity', '0.5');
            $('#mask').css('height', (f.offsetHeight+100)+"px");
        }
    };

    this.save = function(){
        if( working ) return false;
        
        ajaxloader.show();
        $.validator.validate('#form1 .validate', function(error){
            if( !error && validDate() ){

                $.ajax({
                    type : 'post',
                    url  : baseURI+'panel/recitales/ajax_check/',
                    data : {
                        banda     : escape(f.txtBanda.value),
                        recitalid : $(f.recital_id).val()
                    },
                    success : function(data){
                        if( data=="exists" ){
                            show_error(f.txtBanda, 'La banda ingresada ya existe.');
                        }else if( data=="ok" ){
                            f.submit();
                        }else{
                            alert("ERROR:\n"+data);
                        }
                    },
                    error   : function(http){
                        alert("ERROR: \n"+http.responseText);
                    },
                    complete : function(){
                        ajaxloader.hidden();
                    }
                });
            }else{
                ajaxloader.hidden();
            }
        });
        return false;
    };

    this.action={
        New : function(){
            var list = $("#tblList .tbl-body-row");
            if( list.length<5 ){
                location.href = baseURI+"panel/recitales/form";
            }else{
               alert('Estimado usuario, le informamos que el servicio gratuito que usted dispone, le permite cargar un maximo de cinco recitales.');
            }
        },
        edit : function(){
            var list = $("#tblList .tbl-body-row input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar un recital para modificar.");
                return true;
            }
            if( list.length>1 ){
                alert("Solo se puede modificar solo un recital a la vez.");
                return false;
            }
            location.href = baseURI+'panel/recitales/form/'+list.val();
            return false;
        },

        del : function(){
            var list = $("#tblList .tbl-body-row input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar al menos un recital.");
                return false;
            }

            var data = get_data(list);

            if( confirm("¿Está seguro de eliminar?\n\n"+data.names) ){
                location.href = baseURI+'panel/recitales/delete/'+data.id;
            }
            return false;
        },

        lugar_new : function(){
            var tbody = $('#tblLugares').find('tbody');

            if( tbody.find('input.input-lugar').length==0 ){
                var html = '<tr>';
                html+= '<td class="cell-1"><input type="text" id="txtLugarNew" class="input-lugar" onkeypress="if( getKeyCode(event)==13 ) Recitales.action.lugar_save();" /></td>';
                html+= '<td class="cell-2"><img src="images/ajax-loader3.gif" alt="Guardando" title="Guardando" class="hide img-ajaxloader" /> <a href="javascript:void(Recitales.action.lugar_save())" class="link1">Guardar</a></td>';
                html+= '</tr>';
                tbody.prepend(html);
                $('#txtLugarNew').focus();
            }
            return false;
        },
        lugar_del : function(lugar_id, el){
            var lugar_name = $(el).parent().parent().find('td:first').text();
            if( confirm('¿Está seguro de eliminar el lugar "'+lugar_name+'"?') ){
                ajaxloader2.show($(el).parent().find('.img-ajaxloader'));
                $.get(baseURI+'panel/recitales/ajax_del_lugar/'+lugar_id, '', function(result){
                    if( result!="ok" ){
                        alert("ERROR:\n"+result);
                    }else{
                        $(el).parent().parent().remove();
                    }
                    working2=false;
                });
            }
        },
        lugar_save : function(){
            if( working2 || $('#txtLugarNew').val().length==0 ) return false;

            ajaxloader2.show($('#tblLugares tbody tr').eq(0).find('.img-ajaxloader'));
            $.ajax({
                type : 'post',
                url  : baseURI+'panel/recitales/ajax_save_lugar/',
                data : {
                    name    : $('#txtLugarNew').val(),
                    city_id : $('#cboCity').val()
                },
                success : function(result){
                    if( result!="ok" ){
                        alert("ERROR:\n"+result);
                    }else{
                        This.show_list_lugar($('#cboCity')[0]);
                    }
                },
                error : function(http){
                    alert("ERROR:\n"+http.responseText);
                },
                complete : function(){
                    ajaxloader2.hidden();
                }
            });
            
            return false;
        }
    };

    this.sel_lugar = function(){
        ajaxloader.show();
        open_popup(baseURI+'panel/recitales/ajax_load_lugar');
    };

    this.show_city = function(el){
        $('#row-table-lugar').hide();
        $('#row-city').hide();
        if( el.value!=0 ){
            load_combo('panel/recitales/ajax_show_city',el, 'cboCity', function(){
                $('#row-city').fadeIn('slow');
            });
        }
    };
    this.show_list_lugar = function(el){
        $('#row-table-lugar').hide();
        if( el.value!=0 ){
            el.disabled=true;
            $.get(baseURI+'panel/recitales/ajax_list_lugar/'+el.value, '', function(data){
                $('#row-table-lugar').html(data)
                                     .fadeIn('slow');
                el.disabled=false;
            });
        }
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var working2=false;
    var f=false;
    var This=this;

    /* PRIVATE METHODS
     **************************************************************************/
    var show_error = function(el, msg){
        $.validator.show(el,{
            message : msg
        });
        el.focus();
    };

    var validDate = function(){
        var el = $('#txtDate');
        if( el.val()=="" ){
            $.validator.show(el,{
                message : 'Este campo es obligatorio.'
            });
            el.focus();
            return false;
        }else {
            $.validator.hide(el);
            return true;
        }
    }

    var ajaxloader ={
        show : function(){
            $('#mask').show();
            working=true;
        },
        hidden : function(){
            $('#mask').hide();
            working=false;
        }
    }
    var ajaxloader2 ={
        img : false,
        a   : false,
        show : function(img){
            this.img = img
            this.a = this.img.parent().find('a');
            this.img.show();
            this.a.hide();
            working2=true;
        },
        hidden : function(){
            this.img.hide();
            this.a.show();
            working2=false;
        }
    }

    var get_data = function(arr){
        var names="", id="";

        arr.each(function(i){
            id+=this.value+"/";
            names+= $(this).parent().parent().find('.td-name').text()+", ";
        });

        id = id.substr(0, id.length-1);
        names = names.substr(0, names.length-2);

        return {
            id   : id,
            names : names
        }
    };

})();
