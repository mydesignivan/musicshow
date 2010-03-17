    <div class="sidebar">
        <img src="images/title_generos.png" alt="Generos" /><br />
        <ul class="list-generos">
            <?php foreach( $listGeneros->result_array() as $row ){?>
            <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item"><?=$row['name'];?></span></a></li>
            <?php }?>
        </ul>

        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="153" height="217" class="banner">
          <param name="movie" value="images/flash/bannerlaterla.swf" />
          <param name="quality" value="high" />
          <embed src="images/flash/bannerlaterla.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="153" height="217"></embed>
        </object>
    </div>
