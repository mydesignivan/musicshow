    <h1>Editor Index</h1>

    <form id="form1" action="<?=site_url('/paneladmin/index/save/');?>" method="post" class="container-form" enctype="application/x-www-form-urlencoded">
        <p>
            <textarea id="txtContent" name="txtContent" rows="22" cols="5"><?=$info['content'];?></textarea>
        </p>

        <p class="clear span-15 text-center prepend-top">
            <button type="submit" class="button-large">Guardar</button>
        </p>
    </form>