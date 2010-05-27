        <div id="container-lugar">
            <div class="span-9">
                <label class="label-form float-left">Provincia:</label>
                <?=form_dropdown('cboStates', $comboStates,  '0', 'class="select-lugar" id="cboStates" onchange="Recitales.show_city(this);"');?>
            </div>
            <div id="row-city" class="span-9 clear hide">
                <label class="label-form float-left">Ciudad:</label>
                <div id="tooltip-city" class="float-right"><select id="cboCity" class="select-lugar" onchange="Recitales.show_list_lugar(this);"><option></option></select></div>
            </div>
            <div id="row-table-lugar" class="float-left clear hide"></div>            
        </div>
        <div class="clear span-9 prepend-top text-center">
            <button type="button" class="button-medium" onclick="popup.close();">Cerrar</button>
        </div>