        <h1>Bandas</h1>
        
        <?php if( $this->session->flashdata('status')!='' ){?>
        <div class="<?=$this->session->flashdata('status')?>">
            <?=$this->session->flashdata('message')?>
        </div>
        <?php }?>

        <div class="float-right">
            <button type="button" class="button-large" onclick="Bandas.action.del()">Eliminar</button>
        </div>

        <?php if( $listBandas->num_rows>0 ){?>
            <table id="tbl-list" class="table-bandas" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">&nbsp;</td>
                        <td class="cell-2">Nombre</td>
                        <td class="cell-3">Genero</td>
                        <td class="cell-4">Provincia</td>
                        <td class="cell-5">Ciudad</td>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $n=0;
                    foreach( $listBandas->result_array() as $row ){
                    $n++;
                    $class = $n%2 ? '' : 'class="row-par"';
                ?>
                    <tr <?=$class;?>>
                        <td class="cell-1"><input type="checkbox" value="<?=$row['bandas_id'];?>" /></td>
                        <td class="cell-2"><a href="<?=site_url('/paneladmin/bandas/show/'.$row['bandas_id']);?>" class="link-title"><?=$row['name'];?></a></td>
                        <td class="cell-3"><?=$row['genero'];?></td>
                        <td class="cell-4"><?=$row['state'];?></td>
                        <td class="cell-5"><?=$row['city'];?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        
            <div class="text-center"><?=$this->pagination->create_links();?></div>

        <?php }else{?>

            <div class="notice">No hay bandas cargadas</div>

        <?php }?>