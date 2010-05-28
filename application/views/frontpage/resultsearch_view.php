<h1>Recitales</h1>

<?php if( $listResultSearch->num_rows>0 ){?>

<?php
    $arr_seg = $this->uri->uri_to_assoc(3, array('genero', 'state', 'city'));

    $genero = $arr_seg['genero'];
    $city = empty($arr_seg['city']) ? 0 : $arr_seg['city'];
    $state = empty($arr_seg['state']) ? 0 : $arr_seg['state'];

    echo form_dropdown('cboCity', $comboCity,  $city, 'class="select-lugar" id="cboCity" style="margin-left:10px" title="Ciudad" onchange="Filter(this.value, \'city\', '.$genero.','.$state.')"')."&nbsp;&nbsp;";
    echo form_dropdown('cboStates', $comboStates,  $state, 'class="select-lugar" id="cboStates" title="Provincia" onchange="Filter(this.value, \'state\', '.$genero.')"');

    require('ajax/search_list_view.php');
    echo '<div class="clear prepend-top text-center">'. $this->pagination->create_links() .'</div>';

}else{?>
        <div class="anunciante">
            <div class="notice">No se han encontrado resultados.</div>
        </div>
<?php }?>
