<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <title><?=TITLE_GLOBAL . $tlp_title;?></title>
    <meta name="description" content="<?=META_DESCRIPTION;?>" />
    <meta name="keywords" content="<?=META_KEYWORDS;?>" />
    <?php require('includes/head_inc.php');?>
    <?php if( isset($tlp_script) && !empty($tlp_script) ) {
        if( !is_array($tlp_script) ) $tlp_script = array($tlp_script);
        foreach( $tlp_script as $file ){
            require('js/includes/'.$file.'_inc.php');
        }
    }?>
  
</head>

<body>
<div class="container">

    <!-- ================  HEADER  ================ -->
    <?php require('includes/header_inc.php');?>
    <!-- ================  END HEADER  ================ -->

    <!-- ================  MAIN CONTAINER  ================ -->
    <div class="clear span-24 main-container">
        <div class="span-16 column-left">
            <div class="span-16 append-bottom">
            <?php if( $this->config->item('banner_visible') ){?>
                <script type="text/javascript">
                <!--
                    google_ad_client = "pub-0293633642876335";
                    /* 468x60, creado 27/03/10 */
                    google_ad_slot = "8938683242";
                    google_ad_width = 468;
                    google_ad_height = 60;
                //-->
                </script>
                <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
            <?php }?>
            </div>

            <?php require($tlp_section);?>
        </div>

        <div class="span-6 last column-right">
            <div class="sidebar">
                <?php
                    require('includes/sidebar_inc.php');
                    require('includes/banner_vertical_inc.php');
                ?>
            </div>
        </div>
    </div>
    <!-- ================  END MAIN CONTAINER  ================ -->

    <!-- ================  FOOTER  ================ -->
    <?php require('includes/footer_inc.php');?>
    <!-- ================  END FOOTER  ================ -->
</div>
</body>
</html>