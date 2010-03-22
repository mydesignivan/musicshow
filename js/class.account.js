/* 
 * Clase Account
 *
 * Llamada por las vistas: front_registro_view, paneluser_myaccount_view
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

    this.delete_account = function(id){
        var msg = "Si elimina su usuario se eliminara también las propiedades associadas.\n";
        msg+= "¿Está seguro de confirmar la eliminación del usuario?.";
        if( confirm(msg) ){
            location.href = baseURI+"paneluser/micuenta/delete/"+id;
        }
        return false;
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
