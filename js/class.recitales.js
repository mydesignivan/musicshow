/* 
 * Clase Recitales
 *
 * Su funcion: Crear, Modificar o Eliminar recitales
 *
 */

var Recitales = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(param){
        mode_edit=param;

        f = $('#form1')[0];
        if( typeof f!="undefined" ){
            $.validator.setting('#form1 .validate', {
                effect_show     : 'slidefade',
                validateOne     : true
            });

            $('#txtBanda, #cboGenero').validator({
                v_required  : true
            });

            $('#txtDate').datepicker({
                dateFormat : 'dd/mm/yy',
                onClose : function(value){
                    validDate();
                }
            });
        }
        popup.initializer();
        $('a.jq-fancybox').fancybox();
    };

    this.save = function(){
        if( working ) return false;
        
        ajaxloader.show('Validando Formulario');
        $.validator.validate('#form1 .validate', function(error){
            if( !error && validDate() && validLugar() && validImages() ){
                ajaxloader.show('Enviando Formulario');

                /*$.ajax({
                    type : 'post',
                    url  : baseURI+'paneluser/recitales/ajax_check/',
                    data : {
                        banda     : escape(f.txtBanda.value),
                        recitalid : $(f.recital_id).val()
                    },
                    success : function(data){
                        if( data=="exists" ){
                            ajaxloader.hidden();
                            show_error(f.txtBanda, 'La banda ingresada ya existe.');
                        }else if( data=="ok" ){*/
                            if( mode_edit ){
                                f.json.value = JSON.encode({
                                    'lugarvta_id_del' : lugarvta_id_del,
                                    'images_del' : {
                                        'prefix'      :  images_prefix_del,
                                        'image_thumb' :  image_thumb_del,
                                        'image_full'  :  image_full_del
                                    }
                                });
                            }
                            f.submit();
                        /*}else{
                            ajaxloader.hidden();
                            alert("ERROR:\n"+data);
                        }
                    },
                    error   : function(http){
                        ajaxloader.hidden();
                        alert("ERROR: \n"+http.responseText);
                    }
                });*/
            }else{
                ajaxloader.hidden();
            }
        });
        return false;
    };

    this.action={
        edit : function(){
            var list = $("#tbl-list tbody input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar un recital para modificar.");
                return true;
            }
            if( list.length>1 ){
                alert("Solo se puede modificar solo un recital a la vez.");
                return false;
            }
            location.href = baseURI+'paneluser/recitales/form/'+list.val();
            return false;
        },

        del : function(){
            var list = $("#tbl-list tbody input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar al menos un recital.");
                return false;
            }

            var data = get_data(list);

            if( confirm("¿Está seguro de eliminar?\n\n"+data.names) ){
                var controler = location.pathname.indexOf('/paneluser/')>-1 ? 'paneluser' : 'paneladmin';
                location.href = baseURI+controler+'/recitales/delete/'+data.id;
            }
            return false;
        },

        lugar_new : function(){
            var tbody = $('#tblLugares').find('tbody');

            if( tbody.find('input.input-lugar').length==0 ){
                var html = '<tr>';
                html+= '<td class="cell-1"><input type="text" id="txtLugarName" class="input-lugar" onkeypress="if( getKeyCode(event)==13 ) Recitales.action.lugar_save();" /></td>';
                html+= '<td class="cell-2"><input type="text" id="txtLugarAddress" class="input-lugar" onkeypress="if( getKeyCode(event)==13 ) Recitales.action.lugar_save();" /></td>';
                html+= '<td class="cell-3"><img src="images/ajax-loader3.gif" alt="Guardando" title="Guardando" class="hide img-ajaxloader" /> <a href="javascript:void(Recitales.action.lugar_save())" class="link1">Guardar</a></td>';
                html+= '</tr>';
                tbody.prepend(html);
                $('#txtLugarName').focus();
            }
            return false;
        },
        lugar_del : function(lugar_id, el){
            var lugar_name = $(el).parent().parent().find('td:first').text();
            if( confirm('¿Está seguro de eliminar el lugar "'+lugar_name+'"?') ){
                ajaxloader2.show($(el).parent().find('.img-ajaxloader'));
                $.getJSON(baseURI+'paneluser/recitales/ajax_del_lugar/'+lugar_id, '', function(result){
                    if( result.status=="exists_recitales" || result.status=="exists_lugarvta" ){
                        alert('El lugar que intenta eliminar se encuentra asocidado con los sgtes. recitales:\n\n'+result.data);
                    }else if( result.status=="ok" ){
                        $(el).parent().parent().remove();
                    }else{
                        alert("ERROR:\n"+result);
                    }
                    ajaxloader2.hidden();
                });
            }
        },
        lugar_save : function(){
            if( working2 ) return false;
            var lugarName = $('#txtLugarName');
            var lugarAddress = $('#txtLugarAddress');

            if( lugarName.val().length==0 ){
                alert("Debe ingresar el nombre del lugar.");
                lugarName.focus();
                return false;
            }
            if( lugarAddress.val().length==0 ){
                alert("Debe ingresar el domicilio del lugar.");
                lugarAddress.focus();
                return false;
            }

            ajaxloader2.show($('#tblLugares tbody tr').eq(0).find('.img-ajaxloader'));

            var combo = $('#cboCity');
            $.ajax({
                type : 'post',
                url  : baseURI+'paneluser/recitales/ajax_save_lugar/',
                data : {
                    name    : lugarName.val(),
                    address : lugarAddress.val(),
                    id      : combo.val()
                },
                success : function(result){
                    if( result!="ok" ){
                        alert("ERROR:\n"+result);
                    }else{
                        This.show_list_lugar(combo[0]);
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
        },
        lugar_remove : function(el, id){
            var table = $('#tblLugaresVta');
            var rowCurrent = $(el).parent().parent();
            var name = rowCurrent.find(':first').text();
            if( confirm('¿Está seguro de quitar el lugar "'+name+'"?') ){
                rowCurrent.remove();
                if( table.find('tbody tr').length==0 ){
                    table.fadeOut('slow');
                }
                if( id ) lugarvta_id_del.push(id);
            }
        },
        search : function(){
            if( $('#txtSearch').val()=='' ){
                alert('Ingrese una palabara a buscar.');
                $('#txtSearch').focus();
                return false;
            }

            if( $('#cboSearchBy').val()=="date" ) $('#txtSearch').val($('#txtSearch').val().replace(/\//gi, "-"));
            else $('#txtSearch').val($('#txtSearch').val().replace(/\//gi, ""));

            location.href = baseURI+"paneladmin/recitales/search/"+$('#cboSearchBy').val()+"/"+$('#txtSearch').val();
            return false;
        },
        del_image : function(el, prefix){
            if( confirm('¿Está seguro de eliminar?') ){
                $(el).hide();
                $(el).parent().parent().find('.jq-preview').hide();
                set_param_imagesdel(el, prefix);
            }
        }

    };

    this.events = {
        inputfile_change : function(el, prefix){
            set_param_imagesdel(el, prefix);
        }
    };

    this.sel_lugar={
        multiple : false,
        open : function(multiple){
            this.multiple = multiple;
            popup.load({ajaxUrl : baseURI+'paneluser/recitales/ajax_load_lugar'}, {
                reload         : reloadPopup,
                contentDefault : '<div class="text-center"><img src="images/ajax-loader2.gif" alt="Cargando..." /></div>'
            });
            reloadPopup=false;
        },
        select : function(el, lugar_id){
            var cell = $(el).parent().parent().find('td');
            var lugar = cell.eq(0).text();
            var address = cell.eq(1).text();
            var el1 = $('#cboStates')[0], el2 = $('#cboCity')[0];
            var state = el1.options[el1.selectedIndex].text;
            var city = el2.options[el2.selectedIndex].text;

            if( !this.multiple ){
                $('#txtPlace').val(lugar);
                $('#txtAddress').val(address);
                $('#txtState').val(state);
                $('#txtCity').val(city);
                f.lugar_id.value = lugar_id;
                if( $('#txtPlace').parent().parent().find('.jquery-validator').length>0 ){
                    $.validator.hide('#txtAddress');
                }

            }else{
                var table = $('#tblLugaresVta');
                table.fadeIn('slow');
                try{
                    $('#tblLugaresVta tbody .cell-1').each(function(){
                        if( $(this).text()==lugar ){
                           alert('El nombre del lugar "'+ lugar +'" ya existe.');
                           throw true;
                        }
                    });
                }catch(e){return false;}

                var html = '<tr>';
                    html+= '<td class="cell-1">'+ lugar +'</td>';
                    html+= '<td class="cell-2">'+ address +'</td>';
                    html+= '<td class="cell-3">'+ state +'</td>';
                    html+= '<td class="cell-4">'+ city +'</td>';
                    html+= '<td class="cell-5">';
                    html+= '<a href="javascript:void(0)" onclick="Recitales.action.lugar_remove(this)" class="link1">Quitar</a>';
                    html+= '<input type="hidden" name="lugarvta_id[]" value="'+lugar_id+'" />';
                    html+= '</tr>';
                table.find('tbody').append(html);

                if( $('#msg-validator-lugar .jquery-validator').length>0 ){
                    $.validator.hide('#msg-validator-lugar');
                    $('#msg-validator-lugar').empty();
                }

            }
            popup.close();
        }
    };

    this.show_city = function(el){
        $('#row-table-lugar, #row-city, #row-locality').hide();
        if( el.value!=0 ){
            load_combo('paneluser/recitales/ajax_show_city',el, 'cboCity', function(){
                $('#row-city').fadeIn('slow', function(){
                    $('#tooltip-city').tooltip('#tooltip-msg');
                });
                popup.center();
            });
        }
    };
    this.show_list_lugar = function(el){
        $('#row-table-lugar').hide();
        if( el.value!=0 ){
            el.disabled=true;
            $.get(baseURI+'paneluser/recitales/ajax_list_lugar/'+el.value, '', function(data){
                $('#row-table-lugar').html(data)
                                     .fadeIn('slow');
                el.disabled=false;
                popup.center();
                $('#tooltip-msg').hide();
            });
        }
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var working2=false;
    var mode_edit=false;
    var f=false;
    var This=this;
    var lugarvta_id_del = new Array();
    var images_prefix_del = new Array();
    var image_full_del = new Array();
    var image_thumb_del = new Array();
    var reloadPopup=true;

    /* PRIVATE METHODS
     **************************************************************************/
    var validDate = function(){
        var el = $('#txtDate');
        if( el.val()=="" ){
            show_error(el, 'Este campo es obligatorio.');
            return false;
        }else {
            $.validator.hide(el);
            return true;
        }
    };

    var validLugar = function(){
        if( f.lugar_id.value.length==0 ) {
            show_error('#msg-validator-lugar', 'Debe seleccionar un lugar.', '#msg-validator-lugar');
            return false;
        }else $.validator.hide('#msg-validator-lugar');
        /*if( $("[name='lugarvta_id[]']").length==0 ){
            show_error('#msg-validator-lugarvta', 'Debe seleccionar un lugar de venta.', '#msg-validator-lugarvta');
            return false;
        }else $.validator.hide('#msg-validator-lugarvta');*/

        return true;
    };

    var validImages = function(){
        var selector = "#msg-validator-images";
        if( (!mode_edit && $('input.jq-inputfile[value!=""]').length==0) || (mode_edit && $('div.jq-preview:visible').length==0) ){
            show_error(selector, "Debe seleccionar al menos una imagen.", selector);
            return false;
        }

        $.validator.hide('#msg-validator-images');

        return true;
    };

    var ajaxloader ={
        show : function(msg){
            var html = '<div class="text-center">';
                html+= '<p>'+msg+'</p>';
                html+= '<img src="images/ajax-loader.gif" alt="" />';
                html+= '</div>';

            reloadPopup=true;
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
    var ajaxloader2 ={
        img : false,
        a   : false,
        show : function(img){
            this.img = img;
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
    };

    var get_data = function(arr){
        var names="", id="";

        arr.each(function(i){
            id+=this.value+"/";
            names+= $(this).parent().parent().find('.cell-2').text()+", ";
        });

        id = id.substr(0, id.length-1);
        names = names.substr(0, names.length-2);

        return {
            id   : id,
            names : names
        }
    };

    var set_param_imagesdel = function(el, prefix){
        if( images_prefix_del.indexOf(prefix)==-1 ){
            var parent = $(el).parent().parent();
            var tagImg = parent.find('img');
            var tagA = parent.find('a');

            images_prefix_del.push(prefix);
            image_thumb_del.push(tagImg.attr('src'));
            image_full_del.push(tagA.attr('href'));
        }        
    };


})();