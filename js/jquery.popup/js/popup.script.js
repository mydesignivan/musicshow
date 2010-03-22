/*
 * Script: Popup
 * Autor: Ivan Mattoni
 * Empresa: MyDesign
 * Año: 2010
 */

var ClassPopup = function(setting){

    /* PUBLIC PROPERTIES
     *************************************************************************/
    this.isLoad = false;

    /* PUBLIC METHODS
     *************************************************************************/
    this.initializer = function(){
        _maskBG = $(SETTING.maskBG_selector).css({
            'position' : 'absolute',
            'opacity'  : SETTING.maskBG_opacity,
            'left'     : 0,
            'top'      : 0,
            'width'    : $(document.body).width()+"px",
            'height'   : $(document.body).height()+"px"
        });
    };

    this.load = function(_param, _setting){
        var param = {
            ajaxUrl  : '',
            html     : ''
        };
        if( typeof _setting=="object" ) SETTING = $.extend({}, SETTING, {}, _setting);

        param = $.extend({}, param, {}, _param);
        _divPopup = $(SETTING.selector);

        if( SETTING.maskBG_selector!=null ) _maskBG.show();
        if( typeof SETTING.onLoad=="function" ) SETTING.onLoad();

        var content = _divPopup.find(SETTING.selector_content);
        var firstLoad = true;
        var contentDefault="";

        if( !$.data(_divPopup[0], 'jquery_popup') ){
            contentDefault = content.html()
            $.data(_divPopup[0], 'jquery_popup', {contentDefault : contentDefault});
        }else{
            firstLoad = false;
            contentDefault = $.data(_divPopup[0], 'jquery_popup').contentDefault;
        }

        _divPopup.show();

        if( SETTING.reload || firstLoad ) {
            if( param.ajaxUrl!='' ) content.html(contentDefault);
            else{
                if( param.html!='') content.html(param.html);
            }
            _This.center();
        }

        if( !SETTING.bloqEsc ){
            $(document.body).keypress(function(e){
                if( e.keyCode==27 ) _This.close();
            });
        }
        $(window).resize(function() {
            _This.center();
        });

        if( param.ajaxUrl!='' && (SETTING.reload || firstLoad) ) {
            $.get(param.ajaxUrl, '', function(data){
                content.html(data);
            });
        }
        _This.isLoad = true;
    };

    this.close = function(){
        var func = function(){
            if( typeof SETTING.onClose=="function" ) SETTING.onClose();
            $(document.body).unbind('keypress');
            $(window).unbind('resize');
            _maskBG.hide();
            _This.isLoad = false;
        };

        if( SETTING.efectClose ) _divPopup.fadeOut(300, func);
        else func();
    };

    this.center = function(){
        _divPopup.css({
            'left' : (($(window).width()/2)-(_divPopup.width()/2))+"px",
            'top'  : (($(window).height()/2)-(_divPopup.height()/2))+"px"
        });
    };


    /* PRIVATE PROPERTIES
     **********************************************************************/
    var SETTING = {
        selector         : '#jquery-popup',
        selector_content : '.jquery-popup-middle',
        reload           : true,     // Vuelve a mostrar el contenido
        bloqEsc          : false,    // Bloquea el boton escape
        efectClose       : true,     // Efectp fade al cerrar popup
        maskBG_selector  : null,    // Mascara de fondo
        maskBG_opacity   : '0.5',
        onLoad           : null,
        onClose          : null
    };
    var _This=this;
    var _divPopup = false;
    var _maskBG = false;

    /* CONSTRUCTOR
     **********************************************************************/
    SETTING = $.extend({}, SETTING, {}, setting);
}
