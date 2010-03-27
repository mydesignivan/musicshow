    <?php foreach( $listResultSearch->result_array() as $row ){?>
        <div class="anunciante">
            <div class="col-1"><img src="<?=UPLOAD_DIR.$row['image1_thumb'];?>" alt="<?=$row['image1_thumb'];?>" /></div>
            <div class="col-2">
                <h2><?=str_replace(",", "/", $row['date'])." ".$row['banda'];?></h2>
                <p>
                    <label>Ciudad:&nbsp;</label><span><?=$row['city'];?></span>
                </p>
                <p>
                    <label>Lugar:&nbsp;</label><span><?=$row['lugar_name']." - ".$row['lugar_address'];?></span>
                </p>
                <div>
                    <div class="float-left"><label>Genero:&nbsp;</label><span><?=$row['genero'];?></span></div>
                    <div class="float-right"><button type="button" class="button-large" onclick="location.href='<?=site_url('/vermas/index/'.$row['recital_id']);?>'">Ver m&aacute;s</button></div>
                </div>
            </div>
        </div>
    <?php }
