<h1>Fechas</h1>
<?php if( $listResult->num_rows>0 ){?>

<div class="calendar-container">
    <div class="calendar-arrow"><a id="cal-arrowl" href="javascript:void(Dates.previous());" class="arrow hide"><img src="images/icon_previous.png" alt="Anterior" /></a></div>
    <div class="calendar-content">
        <div id="cal-ajaxloader" class="hide">
            <div class="mask"></div>
            <div class="ajaxloader"></div>
        </div>
        <div id="cal-slide" class="calendar-cont-months">
        <?php
        $col=$row=$n=0;
        $data = array();
        foreach( $listResult->result_array() as $rowData ){
            $n++;
            $row++;
            $col++;
            if( $row==1 ) echo '<div class="calendar-months">';
            if( $col==1 ) echo '<div class="float-left">';

            $month = substr($rowData['date'], 3, 2);
            $day = (int)substr($rowData['date'], 0, 2);
            $data = array($day => "javascript:void(Dates.show_result('".$rowData['date']."'));");
  
            echo $this->calendar->generate(date('Y'), $month, $data);

            if( $col==2 || $n==$listResult->num_rows ) {
                echo '</div>';
                $col=0;
            }
            if( $row==4 || $n==$listResult->num_rows ){
                echo '</div>';
                $row=0;
            }
        }?>
        </div>
    </div>
    <div class="calendar-arrow"><a id="cal-arrowr" href="javascript:void(Dates.next());" class="arrow <?php if( $n<=4 ) echo "hide";?>"><img src="images/icon_next.png" alt="Siguiente" /></a></div>
</div>

<script type="text/javascript">
<!--
    Dates.initializer();
-->
</script>

<div id="cal-result" class="prepend-top">
    <?php include('ajax/search_list_view.php');?>
</div>

<?php }else{?>

    <div class="notice">No hay recitales cargados.</div>

<?php }?>
