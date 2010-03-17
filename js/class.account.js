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

        $('#mask').css('opacity', '0.5');
        $('#mask').css('height', (f.offsetHeight+100)+"px");
    };

    this.save = function(){        
        if( working ) return false;
        
        ajaxloader.show();
        return;
        $.validator.validate('#form1 .validate', function(error){
            if( !error ){

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

    this.delete_account = function(id){
        var msg = "Si elimina su usuario se eliminara también las propiedades associadas.\n";
        msg+= "¿Está seguro de confirmar la eliminación del usuario?.";
        if( confirm(msg) ){
            location.href = baseURI+"panel/micuenta/delete/"+id;
        }
        return false;
    };

    this.show_states = function(el){
        el.disabled = true;
        $.get(baseURI+'registro/ajax_show_states/'+el.value,'', function(data){

            $('#cboStates').empty()
                           .append(data);

            el.disabled = false;
        });
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
        show : function(){
            $('#mask').show();
            working=true;
        },
        hidden : function(){
            $('#mask').hide();
            working=false;
        }
    }


})();
