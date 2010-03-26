        <img src="images/title_generos.png" alt="Generos" /><br />
        <ul class="list-generos">
            <?php foreach( $listGeneros as $row ){?>
            <li><a href="<?=site_url('/search/index/genero/'.$row['genero_id']);?>"><img src="images/item.png" alt="" class="item-img" /><span class="item"><?=$row['name'];?></span></a></li>
            <?php }?>
        </ul>

        <div class="float-left prepend-top text-small">
            <label>Buscador</label><br />
            <?php
            $arr_seg = $this->uri->uri_to_assoc(3, array('keyword'));
            ?>
            <input type="text" class="input-search" id="txtSearch" onkeypress="if(getKeyCode(event)==13) search();" value="<?=$arr_seg['keyword'];?>" />
            <button class="button-small" onclick="search();">Buscar</button>
        </div>