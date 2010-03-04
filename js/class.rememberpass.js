/* 
 * Clase RememberPass
 *
 * Llamada por las vistas: front_rememberpass_view
 * Su funcion: envia una nueva contraseña al email del usuario
 *
 */

var RememberPass = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(error){
        f = $('#form1')[0];

        $.validator.setting('#form1 .validate', {
            effect_show     : 'slidefade',
            validateOne     : true
        });

        $(f.txtField).validator({
            v_required   : true
        });
        $(f.txtCode).validator({
            v_required   : true
        });

    };

    this.send = function(){
        if( working ) return false;
        working=true;

        $.validator.validate('#form1 .validate', function(error){
            if( !error ){
                f.submit();
            }
            working=false;
        });

        return false;
    };
    
    /* PRIVATE PROPERTIES
     **************************************************************************/
    var f=false;
    var working=false;

})();