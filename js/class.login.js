/* 
 * Clase Login
 *
 * Llamada por las vistas: header_inc
 * Su funcion: Muestra/Oculta el form de login y permite el logeo al panel.
 *
 */

var Login = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.show_error = function(error){
        switch(error){
            case "loginfaild":
                $("#message-login").html("El usuario y/o password son incorrectos.").show();
            break;
            case "userinactive":
                $("#message-login").html("El usuario no esta activado.").show();
            break;
        }

        $('#message-login').css({
            opacity : 0,
            display : 'block'
        });
        $('#message-login').animate({
            show : 'block',
            top : 0,
            opacity : 1
        }, 1000);
    }


    /* PROPERTIES PRIVATE
     **************************************************************************/

})();
