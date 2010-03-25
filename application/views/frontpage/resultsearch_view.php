<h1>Recitales</h1>

<?php if( $listResultSearch->num_rows>0 ){

    require('ajax/search_list_view.php');
    echo '<div class="clear prepend-top text-center">'. $this->pagination->create_links() .'</div>';

}else{?>
        <div class="anunciante">
            <div class="notice">No se han encontrado resultados.</div>
        </div>
<?php }?>
