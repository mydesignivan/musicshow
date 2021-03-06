/* 
 * Clase Contact
 *
 * Su funcion: Envia formulario de contacto
 *
 */

var Contact = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
     this.initializer = function(){
        f = $('#form1')[0];
        $.validator.setting('#form1 .validate', {
            effect_show     : 'slidefade',
            validateOne     : true
        });

        $("#txtName, #txtConsult").validator({
            v_required  : true
        });
        $("#txtEmail").validator({
            v_required  : true,
            v_email     : true
        });
     };

     this.send = function(){
        if( working ) return false;
        working=true;

        $.validator.validate('#form1 .validate', function(error){
             if( !error ){
                 f.submit();
             }else working=false;
         });
         return false;
     };

    /* PRIVATE PROPERTIES
     **************************************************************************/
     var f=false;
     var working=false;

})();
