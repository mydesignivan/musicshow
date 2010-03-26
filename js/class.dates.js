/* 
 * Clase Dates
 *
 */

var Dates = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    this.initializer = function(_params){
        params.divmonth = $('#cal-slide .calendar-months');
        params.slide = params.divmonth.width();
        params.count_pages = params.divmonth.length;
        $('#cal-ajaxloader .mask').css('opacity', '0.5');
        /*$('#cal-slide .calendar-cont-months').css({
            width : (params.count_pages*params.slide)+"px"
        });*/
    };

    this.next = function(){
        if( page < params.count_pages ){
            //document.title = params.slide;
            $('#cal-arrowl').show();
            $('#cal-arrowr').show();

            page++;
            $('#cal-slide').animate({
                left : '-='+params.slide
            }, 500);

            if( page==params.count_pages ) $('#cal-arrowr').hide();
        }
    };
    this.previous = function(){
        if( page >1 ){
            //document.title = params.slide;
            $('#cal-arrowl').show();
            $('#cal-arrowr').show();

            page--;
            $('#cal-slide').animate({
                left : '+='+params.slide
            }, 500);

            if( page==1 ) $('#cal-arrowl').hide();
        }
    };

    this.show_result = function(date){
        $('#cal-ajaxloader').show();
        $.post(baseURI+'fechas/ajax_show_result', {date : date}, function(data){
            $('#cal-result').html(data);
            $('#cal-ajaxloader').hide();
        });
    };


    /* PROPERTIES PRIVATE
     **************************************************************************/
    var params={};
    var page=1;

    /* PRIVATE METHODS
     **************************************************************************/

})();
