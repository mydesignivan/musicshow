<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class bandas_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function create($uploadImageBanda, $uploadImageDisc) {
        $data = $this->_get_data();
        $data['date_added'] = date('Y-m-d H:i:s');

        $this->db->trans_start(); // INICIO TRANSACCION

        try{

            // ALTA DATOS "BANDAS"
            if( !$this->db->insert(TBL_BANDAS, $data) ) throw true;
            $bandas_id = $this->db->insert_id();

            // ALTA DATOS "INTEGRANTES"
            if( !$this->_save_integrantes($bandas_id) ) throw true;

            // ALTA DATOS "IMAGENES BANDAS"
            if( !$this->_save_imagesbanda($uploadImageBanda, $bandas_id) ) throw true;

            // ALTA DATOS "DISCOGRAFICA"
            if( $_POST['optDiscografia']==1 ){
                $n=0;
                $arr_track = json_decode($_POST['extra_post']);

                foreach( $uploadImageDisc as $row ){
                    if( !empty($_POST['txtDiscName'][$n]) && !empty($_POST['txtDiscCDname'][$n]) ) {
                        $data = array(
                            'bandas_id'   => $bandas_id,
                            'discografia' => $_POST['txtDiscName'][$n],
                            'cd_name'     => $_POST['txtDiscCDname'][$n],
                            'thumb'       => $row['filename_thumb'],
                            'image'       => $row['filename_image'],
                            'width'       => $row['thumb_width'],
                            'height'      => $row['thumb_height']
                        );
                        if( !$this->db->insert(TBL_BANDASDISC, $data) ) throw true;
                        $disc_id = $this->db->insert_id();

                        // ALTA DATOS "TEMAS DISCOGRAFICA"
                        foreach( $arr_track[$n] as $rowTrack ){
                            $data = array(
                                'discografica_id' => $disc_id,
                                'name'            => $rowTrack->name,
                                'minutes'         => $rowTrack->minutes
                            );
                            if( !$this->db->insert(TBL_BANDASDISCTRACK, $data) ) throw true;
                        }
                        
                    }
                    $n++;
                }
            }
            
            // ALTA DATOS "OTROS CONTACTO"
            if( !$this->_save_othercontact($bandas_id) ) throw true;

            // ALTA DATOS "LA BANDA EN LA WEB"
            if( !$this->_save_weblink($bandas_id) ) throw true;


            $this->db->trans_complete(); // COMPLETO LA TRANSACCION


        }catch(Exception $e){
            
            return false;
        }

        return true;
    }

    public function edit($uploadImageBanda, $uploadImageBandaEdit, $uploadImageDisc, $uploadImageDiscEdit) {
        $data = $this->_get_data();
        $data['last_modified'] = date('Y-m-d H:i:s');

        $this->db->trans_start(); // INICIO TRANSACCION

        try{
            $bandas_id = $_POST['bandas_id'];
            $extra_post = json_decode($_POST['extra_post']);

            // EDIT DATOS "BANDAS"
            $this->db->where('bandas_id', $bandas_id);
            if( !$this->db->update(TBL_BANDAS, $data) ) throw true;

            // EDIT DATOS "INTEGRANTES"
            $this->db->delete(TBL_BANDASINT, array('bandas_id' => $bandas_id));
            if( !$this->_save_integrantes($bandas_id) ) throw true;

            // ALTA DATOS "IMAGENES BANDAS"
            if( !$this->_save_imagesbanda($uploadImageBanda, $bandas_id) ) throw true;

            // EDIT DATOS "IMAGENES BANDAS"
            $n=0;
            foreach( $uploadImageBandaEdit as $row ){
                $data = array(
                    'image'      => $row['filename_image'],
                    'thumb'      => $row['filename_thumb'],
                    'width'      => $row['thumb_width'],
                    'height'     => $row['thumb_height']
                );
                $this->db->where('bandagallerie_id', $extra_post->bandagallerie_id[$n]);
                if( !$this->db->update(TBL_BANDASGALLERY, $data) ) return false;
                else{
                    @unlink($extra_post->href_imgbanda_image[$n]);
                    @unlink($extra_post->href_imgbanda_thumb[$n]);
                }

                $n++;
            }

            for( $n=0; $n<=count($_POST['id_imagebanda'])-1; $n++ ){
                $this->db->where('bandagallerie_id', $_POST['id_imagebanda'][$n]);
                if( !$this->db->update(TBL_BANDASGALLERY, array('comment' => $_POST['txtImageCommentEdit'][$n])) ) return false;
            }
            
            // DELETE DATOS "IMAGENES BANDAS"
            if( count($extra_post->image_del)>0 ){
                $this->db->where_in("bandagallerie_id", $extra_post->image_del);
                $this->db->delete(TBL_BANDASGALLERY);
            }


            if( $_POST['optDiscografia']==1 ){
                // ALTA DATOS "DISCOGRAFICA"
                $n=0;
                foreach( $uploadImageDisc as $row ){
                    if( !empty($_POST['txtDiscCDname'][$n]) ) {
                        $data = array(
                            'bandas_id'   => $bandas_id,
                            'discografia' => $_POST['txtDiscName'][$n],
                            'cd_name'     => $_POST['txtDiscCDname'][$n],
                            'thumb'       => $row['filename_thumb'],
                            'image'       => $row['filename_image'],
                            'width'       => $row['thumb_width'],
                            'height'      => $row['thumb_height']
                        );
                        if( !$this->db->insert(TBL_BANDASDISC, $data) ) throw true;
                        $disc_id = $this->db->insert_id();

                        // ALTA DATOS "TEMAS DISCOGRAFICA"
                        foreach( $extra_post->tracks[$n] as $rowTrack ){
                            $data = array(
                                'discografica_id' => $disc_id,
                                'name'            => $rowTrack->name,
                                'minutes'         => $rowTrack->minutes
                            );
                            if( !$this->db->insert(TBL_BANDASDISCTRACK, $data) ) throw true;
                        }
                    }
                    $n++;
                }

                // EDIT DATOS "DISCOGRAFICA"
                $n=0;
                foreach( $uploadImageDiscEdit as $row ){
                    if( !empty($_POST['txtDiscCDnameEdit'][$n]) ) {
                        $data = array(
                            'thumb'       => $row['filename_thumb'],
                            'image'       => $row['filename_image'],
                            'width'       => $row['thumb_width'],
                            'height'      => $row['thumb_height']
                        );
                        $this->db->where('discografica_id', $extra_post->discografica_id[$n]);
                        if( !$this->db->update(TBL_BANDASDISC, $data) ) throw true;
                    }
                    $n++;
                }

                for( $n=0; $n<=count($_POST['discografica_id'])-1; $n++ ){
                    $data = array(
                        'discografia' => $_POST['txtDiscCDnameEdit'][$n],
                        'cd_name' => $_POST['txtDiscNameEdit'][$n]
                    );
                    $this->db->where('discografica_id', $_POST['discografica_id'][$n]);
                    if( !$this->db->update(TBL_BANDASDISC, $data) ) return false;

                    // ALTA DATOS "TEMAS DISCOGRAFICA"
                    $this->db->delete(TBL_BANDASDISCTRACK, array('discografica_id' => $_POST['discografica_id'][$n]));
                    foreach( $extra_post->tracks_edit[$n] as $rowTrack ){
                        $data = array(
                            'discografica_id' => $_POST['discografica_id'][$n],
                            'name'            => $rowTrack->name,
                            'minutes'         => $rowTrack->minutes
                        );
                        if( !$this->db->insert(TBL_BANDASDISCTRACK, $data) ) throw true;
                    }

                }

                // DELETE DATOS "DISCOGRAFICA"
                if( count($extra_post->imagedisc_del)>0 ){
                    $this->db->where_in("discografica_id", $extra_post->imagedisc_del);
                    $this->db->delete(TBL_BANDASDISC);
                }

            }

            // ALTA DATOS "OTROS CONTACTO"
            $this->db->delete(TBL_BANDASOTHERCONTACTS, array('bandas_id' => $bandas_id));
            if( !$this->_save_othercontact($bandas_id) ) throw true;

            // ALTA DATOS "LA BANDA EN LA WEB"
            $this->db->delete(TBL_BANDASWEBLINK, array('bandas_id' => $bandas_id));
            if( !$this->_save_weblink($bandas_id) ) throw true;

            $this->db->trans_complete(); // COMPLETO LA TRANSACCION


        }catch(Exception $e){

            return false;
        }

            die("ok");
        return true;
    }
    
    public function delete($where){

    }

    public function get_list($limit, $offset, $where=array()) {
        $sql = "bandas_id, name, genero,";
        $sql.= "(SELECT name FROM ".TBL_STATES." WHERE state_id=".TBL_BANDAS.".state_id) as state,";
        $sql.= "(SELECT name FROM ".TBL_CITY." WHERE city_id=".TBL_BANDAS.".city_id) as city";
        $ret = array();

        $this->db->select($sql, false);
        $this->db->where($where);
        $ret['count_rows'] = $this->db->count_all_results(TBL_BANDAS);

        $this->db->select($sql, false);
        $this->db->where($where);
        $this->db->order_by('bandas_id', 'desc');
        $ret['result'] = $this->db->get(TBL_BANDAS, $limit, $offset);
        
        return $ret;
    }

    public function get_info($id){
        $this->load->model('lists_model');

        $info = array();
        // DATOS DE LA BANDA
        $info = $this->db->get_where(TBL_BANDAS, array('bandas_id'=>$id))->row_array();

        // LISTADO DE CIUDADES
        $info['comboCity'] = $this->lists_model->get_city(array(""=>"Seleccione una Ciudad"), $info['state_id']);

        // LISTADO DE INTEGRANTES
        $info['listIntegrantes'] = $this->db->get_where(TBL_BANDASINT, array('bandas_id'=>$id));

        // LISTADO DE IMAGENES
        $info['listImages'] = $this->db->get_where(TBL_BANDASGALLERY, array('bandas_id'=>$id));

        // LISTADO DISCOGRAFICA
        if( $info['discografica_visible']==1 ){
            $listDisc = $this->db->get_where(TBL_BANDASDISC, array('bandas_id'=>$id))->result_array();
            $info['listDisc'] = array();
            foreach( $listDisc as $row ){
                // LISTADO DISCOGRAFICA TEMAS
                $row['tracks'] = $this->db->get_where(TBL_BANDASDISCTRACK, array('discografica_id'=>$row['discografica_id']))->result_array();
                $info['listDisc'][] = $row;
            }
        }

        // LISTADO OTROS CONTACTO
        $info['listOtherContact'] = $this->db->get_where(TBL_BANDASOTHERCONTACTS, array('bandas_id'=>$id));

        // LISTADO WEBLINKS
        $info['listWebLink'] = $this->db->get_where(TBL_BANDASWEBLINK, array('bandas_id'=>$id));

        return $info;
    }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_data(){
        return array(
            '`name`' => $_POST['txtBanda'],
            '`genero`' => $_POST['txtGenero'],
            '`state_id`' => $_POST['cboStates'],
            '`city_id`' => $_POST['cboCity'],
            '`influencias`' => $_POST['txtInfluencias'],
            '`discografica_visible`' => $_POST['optDiscografia'],
            '`discografica_actual`' => $_POST['txtDiscActual'],
            '`history`' => $_POST['txtHistory'],
            '`tocando_desde`' => $_POST['txtTocandoDesde'],
            '`manager_visible`' => $_POST['optManager'],
            '`manager_name`' => $_POST['txtManagerName'],
            '`manager_phone`' => $_POST['txtManagerPhone'],
            '`manager_mail`' => $_POST['txtManagerEmail'],
            '`contact_name`' => $_POST['txtContactName'],
            '`contact_phone`' => $_POST['txtContactPhone'],
            '`contact_mail`' => $_POST['txtContactEmail'],
            '`link_url`' => $_POST['txtLinksInteresUrl'],
            '`link_title`' => $_POST['txtLinksInteresTitle'],
            '`masinfo`' => $_POST['txtMoreInfo']
        );
    }

    private function _save_integrantes($bandas_id){
        for( $n=0; $n<=count($_POST['txtIntegName'])-1; $n++ ){
            $data = array(
                'bandas_id'  => $bandas_id,
                'name'       => $_POST['txtIntegName'][$n],
                'instrument' => $_POST['txtIntegInstr'][$n]
            );
            if( !$this->db->insert(TBL_BANDASINT, $data) ) return false;
        }
        return true;
    }

    private function _save_othercontact($bandas_id){
        for( $n=0; $n<=count($_POST['txtContactOtherName'])-1; $n++ ){
            $data = array(
                'bandas_id'  => $bandas_id,
                'name'       => $_POST['txtContactOtherName'][$n],
                'phone'      => $_POST['txtContactOtherPhone'][$n],
                'email'      => $_POST['txtContactOtherEmail'][$n]
            );
            if( !$this->db->insert(TBL_BANDASOTHERCONTACTS, $data) ) return false;
        }
        return true;
    }

    private function _save_weblink($bandas_id){
        for( $n=0; $n<=count($_POST['cboBandaWeb'])-1; $n++ ){
            $data = array(
                'bandas_id'   => $bandas_id,
                'title'       => $_POST['cboBandaWeb'][$n],
                'title_other' => $_POST['txtOtherBanda'][$n],
                'url'         => $_POST['txtBandaWebVal'][$n]
            );
            if( !$this->db->insert(TBL_BANDASWEBLINK, $data) ) return false;
        }
        return true;
    }

    private function _save_imagesbanda($uploadImageBanda, $bandas_id){
        $n=0;
        foreach( $uploadImageBanda as $row ){
            $data = array(
                'bandas_id'  => $bandas_id,
                'image'      => $row['filename_image'],
                'thumb'      => $row['filename_thumb'],
                'width'      => $row['thumb_width'],
                'height'     => $row['thumb_height'],
                'comment'    => @$_POST['txtImageComment'][$n]
            );
            if( !$this->db->insert(TBL_BANDASGALLERY, $data) ) return false;
            $n++;
        }
        return true;
    }


}
?>