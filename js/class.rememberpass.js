/* 
 * Clase RememberPass
 *
 * Llamada por las vistas: front_rememberpass_view, front_passwordreset_view
 * Su funcion: envia una nueva contraseña al email del usuario
 *
 */

var RememberPass = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(){
        if( $('#form1').length>0 ){
            f = $('#form1')[0];

            $.validator.setting('#form1 .validate', {
                effect_show     : 'slidefade',
                validateOne     : true
            });

            $("#txtField, #txtCode").validator({
                v_required   : true
            });


        }else if( $('#form2').length>0 ){
            f = $('#form2')[0];

            $.validator.setting('#form2 .validate', {
                effect_show     : 'slidefade',
                validateOne     : true,
                addClass        : 'validator-passreset'
            });

            $("#txtPass").validator({
                v_required   : true,
                v_password   : [8,10]
            });
            $('#txtPass_confirm').validator({
                v_required : true,
                v_compare  : '#txtPass'
            });
        }

    };

    this.send = function(){
        if( working ) return false;
        working=true;

        $.validator.validate('#form1 .validate', function(error){
            if( !error ){

                $.ajax({
                    type : 'post',
                    url  : baseURI+'recordarcontrasenia/ajax_check',
                    data : {
                        field   : f.txtField.value,
                        captcha : f.txtCode.value
                    },
                    success : function(data){
                        if( data=="notexists" ){
                            show_error(f.txtField, 'La direcci&oacute;n de correo electr&oacute;nico o el usuario que has puesto no la reconocemos. Por favor int&eacute;ntalo de nuevo o ponte en contacto con el <a href="'+baseURI+'contacto">administrador</a>.');
                        }else if( data=="userinactive" ){
                            show_error(f.txtField, 'El usuario se encuentra inactivo.');
                        }else if( data=="captcha_error" ){
                            show_error(f.txtCode, 'El c&oacute;digo ingresado es incorrecto.');
                        }else if( data=="ok" ){
                            f.submit();
                        }else{
                            alert("ERROR: \n"+data);
                        }
                    },
                    error : function(xml){
                        alert("ERROR: \n"+xml.responseText);
                    },
                    complete : function(){
                        working = false;
                    }
                });

            }else working=false;
        });

        return false;
    };

    this.send2 = function(){
        $.validator.validate('#form2 .validate', function(error){
            if( !error ){
                f.submit();
            }
        });
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var f=false;
    var working=false;

    /* PRIVATE METHODS
     **************************************************************************/
    var show_error = function(el, msg){
        $.validator.show(el,{
            message : msg
        });
        el.focus();
    };

})();