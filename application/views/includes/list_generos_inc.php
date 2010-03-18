        <img src="images/title_generos.png" alt="Generos" /><br />
        <ul class="list-generos">
            <?php foreach( $listGeneros as $row ){?>
            <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item"><?=$row['name'];?></span></a></li>
            <?php }?>
        </ul>
