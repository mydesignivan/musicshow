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
        }
    };

    this.save = function(){
        if( working ) return false;
        
        ajaxloader.show();
        $.validator.validate('#form1 .validate', function(error){
            if( !error && validDate() ){

                $.ajax({
                    type : 'post',
                    url  : baseURI+'recitales/ajax_check/',
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
                location.href = baseURI+"recitales/form";
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
            location.href = baseURI+'recitales/form/'+list.val();
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
                location.href = baseURI+'recitales/delete/'+data.id;
            }
            return false;
        }
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var f=false;


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
