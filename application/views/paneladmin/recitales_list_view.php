        <h1>Recitales</h1>

        <div class="float-left">
            <form name="formSearch" action="<?=site_url('/paneladmin/recitales/');?>" method="get" enctype="application/x-www-form-urlencoded">
                <label class="label-form">Buscar por:&nbsp;</label>
                <select name="cboSearchBy">
                    <option value="banda" <?php if( @$_POST['cboSearchBy']=="banda" ) echo 'selected="selected"';?>>Banda</option>
                    <option value="lugar_name" <?php if( @$_POST['cboSearchBy']=="lugar_name" ) echo 'selected="selected"';?>>Lugar</option>
                    <option value="date" <?php if( @$_POST['cboSearchBy']=="date" ) echo 'selected="selected"';?>>Fecha</option>
                </select>
                <input type="text" class="input-medium" name="txtSearch" value="<?=@$_POST['txtSearch'];?>" />
                <button type="submit" class="button-medium">Buscar</button>
            </form>
        </div>
        <div class="float-right">
            <button type="button" class="button-large" onclick="Recitales.action.del()">Eliminar</button>
        </div>

        <?php if( $listRecitales->num_rows>0 ){?>
            <table id="tbl-list" class="table-list" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">&nbsp;</td>
                        <td class="cell-2">Banda</td>
                        <td class="cell-3">Lugar</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $n=0;
                    foreach( $listRecitales->result_array() as $row ){
                    $n++;
                    $class = $n%2 ? '' : 'class="row-par"';
                    $lastSegment = $this->uri->segment($this->uri->total_segments());
                    if( !is_numeric($lastSegment) ) $lastSegment="";
                ?>
                    <tr <?=$class;?>>
                        <td class="cell-1"><input type="checkbox" value="<?=$row['recital_id'];?>" /></td>
                        <td class="cell-2"><a href="<?=site_url('/paneladmin/recitales/view/' .$row['recital_id'] ."/". $lastSegment);?>" class="link-title"><?=$row['banda'];?></a></td>
                        <td class="cell-3"><?=$row['lugar_name'];?></td>
                        <td><?=$row['date'];?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

            <div class="text-center"><?= $this->pagination->create_links();?></div>


        <?php }else{?>

            <div class="notice">No hay recitales cargados</div>

        <?php }?>