<h1>Recitales</h1>

<?php if( $listResult->num_rows>0 ){?>
    <?php foreach( $listResult->result_array() as $row ){?>
        <div class="anunciante">
            <div class="col-1"><img src="<?=UPLOAD_DIR.$row['image1_thumb'];?>" alt="<?=$row['image1_thumb'];?>" /></div>
            <div class="col-2">
                <h2><?=$row['date']." ".$row['banda'];?></h2>
                <p>
                    <label>Ciudad:&nbsp;</label><span><?=$row['city'];?></span>
                </p>
                <p>
                    <label>Lugar:&nbsp;</label><span><?=$row['lugar_name']." - ".$row['lugar_address'];?></span>
                </p>
                <p>
                    <label>Genero:&nbsp;</label><span><?=$row['genero'];?></span>
                </p>
            </div>
        </div>
        <div class="clear prepend-top text-center"><?= $this->pagination->create_links();?></div>
    <?php }

}else{?>
        <div class="anunciante">
            <div class="notice">No se han encontrado resultados.</div>
        </div>
<?php }?>
