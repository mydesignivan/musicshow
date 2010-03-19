<base href="<?=base_url();?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="images/favicon.ico" rel="stylesheet icon" type="image/ico" />

<!-- Framework CSS  (BluePrint) -->
<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection"/>
<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print"/>
<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"/><![endif]-->
<!-------- end block -------->

<link href="css/style.css" rel="stylesheet" type="text/css" />

<!--[if IE 6]> 
<link rel="stylesheet" href="css/styleIE6.css" type="text/css" />
<![endif]-->
<!--[if IE7]>
<link rel="stylesheet" href="css/styleIE7.css" type="text/css" />
<![endif]-->


<!--========== LIBRARIES ============-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/helpers.min.js"></script>
<script type="text/javascript" src="js/class.login.js"></script>
<script type="text/javascript" src="js/comun.js"></script>
<!--========== END LIBRARIES =======-->

<script type="text/javascript">
<!--
    if( $.browser.opera ) $('head').append($('<link href="css/styleOpera.css" rel="stylesheet" type="text/css" />'));
    //if( $.browser.safari ) $('head').append($('<link href="css/styleSafari.css" rel="stylesheet" type="text/css" />'));
    //if( $.browser.opera ) $('head').append($('<link href="css/styleOpera.css" rel="stylesheet" type="text/css" />'));
-->
</script>

<script type="text/javascript">
<!--
<?php
    $indexphp = index_page();
    if( !empty($indexphp) ) $indexphp.="/";
?>
    var baseURI = $("base").attr("href")+"<?=$indexphp;?>";
-->
</script>


<!--[if IE 6]>
<script type="text/javascript">
    var IE6UPDATE_OPTIONS = {
        icons_path: "js/ie6update/ie6update/images/"
    }
</script>
<script type="text/javascript" src="_js/ie6update/ie6update/ie6update.js"></script>
<![endif]-->

<!--[if IE 6]>
<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
<![endif]-->

<?php $execscript=true;?>