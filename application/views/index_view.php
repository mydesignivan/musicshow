<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Shows</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <?php include("includes/head_inc.php");?>
</head>

<body>
<div id="container">
    <?php include("includes/header_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <?php for( $n=1; $n<=10; $n++ ){?>
        <div class="anunciante">
            <div class="imganunciante"><img src="images/images.jpg" height="100" alt="foto" /></div>
            <div class="datosanunciante">
                <h3>12/12/12 Rock</h3>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula.
            </div>
            <div class="masinfo"><a href="#">+ mas info</a></div>
        </div>
        <?php }?>

        <div id="sticky">
            <img src="images/sticky.png" alt="" />
           <br class="clearfloat" />
        </div>
    </div>
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>

</div>

</body>
</html>
