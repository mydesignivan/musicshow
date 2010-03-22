        <h1>Usuarios</h1>

        <div class="float-left">
            <?php
                $cboSearchBy = "banda";
                $txtSearch = "";
                if( $this->uri->segment(3)=="search" ){
                    $cboSearchBy = $this->uri->segment(4);
                    $txtSearch = $this->uri->segment(5);
                }
            ?>
            <label class="label-form">Buscar por:&nbsp;</label>
            <select id="cboSearchBy" onchange="Account.events.change_searchby(this.value);">
                <option value="username" <?php if( $cboSearchBy=="username" ) echo 'selected="selected"';?>>Nombre Usuario</option>
                <option value="name" <?php if( $cboSearchBy=="name" ) echo 'selected="selected"';?>>Nombre y Apellido</option>
                <option value="active" <?php if( $cboSearchBy=="active" ) echo 'selected="selected"';?>>Estado</option>
            </select>

            <input type="text" class="input-medium <?php if( $cboSearchBy=="active" ) echo "hide";?>" id="txtSearch" value="<?=$txtSearch;?>" onkeypress="if( getKeyCode(event)==13 ) Account.action.search();" />
            <select id="cboUserActive" class="<?php if( $cboSearchBy!="active" ) echo "hide";?>">
                <option value="1" <?php if( $txtSearch==1 ) echo 'selected="selected"';?>>Activo</option>
                <option value="0" <?php if( $txtSearch==0 ) echo 'selected="selected"';?>>Inactivo</option>
            </select>

            <button type="button" class="button-medium" onclick="Account.action.search();">Buscar</button>
        </div>
        <div class="float-right">
            <button type="button" class="button-large" onclick="Account.action.del()">Eliminar</button>
        </div>

        <?php if( $listUsers->num_rows>0 ){?>
            <table id="tbl-list" class="table-list" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">&nbsp;</td>
                        <td class="cell-2">Nombre Usuario</td>
                        <td class="cell-3">Nombre y Apellido</td>
                        <td class="text-center">Estado</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $n=0;
                    foreach( $listUsers->result_array() as $row ){
                    $n++;
                    $class = $n%2 ? '' : 'class="row-par"';
                    $lastSegment = $this->uri->segment($this->uri->total_segments());
                    if( !is_numeric($lastSegment) ) $lastSegment="";
                ?>
                    <tr <?=$class;?>>
                        <td class="cell-1"><input type="checkbox" value="<?=$row['user_id'];?>" /></td>
                        <td class="cell-2"><a href="<?=site_url('/paneladmin/usuarios/view/' .$row['user_id'] ."/". $lastSegment);?>" class="link-title"><?=$row['username'];?></a></td>
                        <td class="cell-3"><?=$row['name'];?></td>
                        <td class="text-center"><?=$row['active']==1 ? "Activo" : "Inactivo";?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

            <div class="text-center"><?= $this->pagination->create_links();?></div>


        <?php }else{
            
            echo '<div class="notice">No hay Usuarios cargados</div>';

        }?>