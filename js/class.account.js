/* 
 * Clase Account
 *
 * Su funcion: Crear, Modificar o Eliminar usuarios
 *
 */

var Account = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(){
        f = $('#form1')[0];
        $.validator.setting('#form1 .validate', {
            effect_show     : 'slidefade',
            validateOne     : true
        });

        $('#txtUser').validator({
            v_required  : true,
            v_user      : [5,10]
        });
        $('#txtEmail').validator({
            v_required : true,
            v_email    : true
        });
        $('#txtPass').validator({
            v_required : ($(f.user_id).val()!='') ? false : true,
            v_password : [8,10]
        });
        $('#txtPass_confirm').validator({
            v_required : ($(f.user_id).val()!='') ? false : true,
            v_compare  : '#txtPass'
        });

        $('#txtLastName, #txtFirstName, #cboCountry, #cboStates, #txtCity, #txtPhone, #txtCode').validator({
            v_required  : true
        });
        popup.initializer();
    };

    this.save = function(){        
        if( working ) return false;
        
        ajaxloader.show('Validando Formulario.');
        $.validator.validate('#form1 .validate', function(error){
            if( !error ){
                ajaxloader.show('Enviando Formulario');

                $.ajax({
                    type : 'post',
                    url  : baseURI+'registro/ajax_check/',
                    data : {
                        username : escape(f.txtUser.value),
                        email    : escape(f.txtEmail.value),
                        captcha  : $(f.txtCode).val(),
                        userid   : $(f.user_id).val()
                    },
                    success : function(data){
                        if( data=="existsuser" ){
                            show_error(f.txtUser, 'El usuario ingresado ya existe.');
                        }else if( data=="existsmail" ){
                            show_error(f.txtEmail, 'El email ingresado ya existe.');
                        }else if( data=="captcha_error" ){
                            show_error(f.txtCode, 'El c&oacute;digo ingresado es incorrecto.');

                        }else if( data=="ok" ){
                            f.submit();
                        }else{
                            alert("ERROR:\n"+data);
                        }
                        if( data!="ok" ) ajaxloader.hidden();
                    },
                    error   : function(http){
                        alert("ERROR: \n"+http.responseText);
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
        search : function(){
            var input = $('#txtSearch');
            var search = input.val();

            if( $('#cboSearchBy').val()!="active" && search=='' ){
                alert('Ingrese una palabara a buscar.');
                input.focus();
                return false;
            }

            search = search.replace(/\//gi, "");

            if( $('#cboSearchBy').val()=="active" ) search = $('#cboUserActive').val();

            location.href = baseURI+"paneladmin/usuarios/search/"+$('#cboSearchBy').val()+"/"+search;
            return false;
        },
        del : function(){
            var list = $("#tbl-list tbody input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar al menos un usuario.");
                return false;
            }

            var data = get_data(list);

            if( confirm("¿Está seguro de eliminar?\n\n"+data.names) ){
                location.href = baseURI+'paneladmin/usuarios/delete/'+data.id;
            }
            return false;
        }
    };

    this.events={
        change_searchby : function(value){
            $('#txtSearch').val("");
            if( value=="active" ) {
                $('#cboUserActive').show();
                $('#txtSearch').hide();
            }else {
                $('#cboUserActive').hide();
                $('#txtSearch').show();
            }
        }
    };

    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;
    var f=false;


    /* PRIVATE METHODS
     **************************************************************************/
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


})();
