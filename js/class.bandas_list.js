var Bandas = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(){

    };

    this.action={
        edit : function(){
            var list = $("#tbl-list tbody input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar una banda para modificar.");
                return true;
            }
            if( list.length>1 ){
                alert("Solo se puede modificar una banda a la vez.");
                return false;
            }
            location.href = baseURI+'paneluser/bandas/form/'+list.val();
            return false;
        },

        del : function(){
            var list = $("#tbl-list tbody input:checked");
            if( list.length==0 ){
                alert("Debe seleccionar al menos una banda.");
                return false;
            }

            var data = get_data(list);

            if( confirm("¿Está seguro de eliminar?\n\n"+data.names) ){
                var controler = location.pathname.indexOf('/paneluser/')>-1 ? 'paneluser' : 'paneladmin';
                location.href = baseURI+controler+'/bandas/delete/'+data.id;
            }
            return false;
        }
    };


    /* PRIVATE PROPERTIES
     **************************************************************************/
    var working=false;

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

})();