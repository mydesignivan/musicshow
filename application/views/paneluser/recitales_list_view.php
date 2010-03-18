        <h1>Recitales</h1>

        <div class="float-right">
            <button type="button" class="button-large" onclick="Recitales.action.New()">Nuevo</button>
            <?php if( $listRecitales->num_rows>0 ){?>
            <button type="button" class="button-large" onclick="Recitales.action.edit()">Modificar</button>
            <button type="button" class="button-large" onclick="Recitales.action.del()">Eliminar</button>
            <?php }?>
        </div>

        <?php if( $listRecitales->num_rows>0 ){?>
            <table class="table-list" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">&nbsp;</td>
                        <td class="cell-2">Banda</td>
                        <td class="cell-3">Lugar</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach( $listRecitales->result_array() as $row ){?>
                    <tr>
                        <td class="cell-1"><input type="checkbox" value="<?=$row['recital_id'];?>" /></td>
                        <td class="cell-2"><a href="<?=site_url('/panel/recitales/form/'.$row['recital_id']);?>" class="link-title"><?=$row['banda'];?></a></td>
                        <td class="cell-3"><?=$row['place'];?></td>
                        <td><?=$row['date'];?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        <?php }else{?>

            <div class="notice">No hay recitales cargados</div>

        <?php }?>