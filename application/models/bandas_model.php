<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class bandas_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function create($data = array()) {

        $lugarvta_id = $data['lugarvta_id'];
        unset($data['lugarvta_id']);

        if( !$this->db->insert(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_RECITALES));
        }
        
        $recital_id = $this->db->insert_id();

        if( is_array($lugarvta_id) ){
            foreach( $lugarvta_id as $id ){
                $data = array(
                    'recital_id' => $recital_id,
                    'lugar_id'   => $id,
                    'user_id'    => $this->session->userdata('user_id')
                );

                if( !$this->db->insert(TBL_RECITALES_TO_LUGARVTA, $data) ) {
                    show_error(sprintf(ERR_DB_INSERT, TBL_RECITALES_TO_LUGARVTA));
                }
            }
        }

        return $recital_id;
    }

    public function edit($data = array(), $recital_id=null) {

        $lugarvta_id = $data['lugarvta_id'];
        $json = json_decode($data['json']);

        unset($data['lugarvta_id']);
        unset($data['json']);

        $this->db->where('recital_id', $recital_id);
        if( !$this->db->update(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_RECITALES));
        }

        $result_table = $this->db->get_where(TBL_RECITALES_TO_LUGARVTA, array('recital_id'=>$recital_id))->result_array();

        if( is_array($lugarvta_id) ){
            foreach( $lugarvta_id as $id ){
                if( !arr_search($result_table, "lugar_id==".$id) ){
                    $data2 = array(
                        'recital_id' => $recital_id,
                        'lugar_id'   => $id,
                        'user_id'    => $this->session->userdata('user_id')
                    );
                    if( !$this->db->insert(TBL_RECITALES_TO_LUGARVTA, $data2) ) {
                        show_error(sprintf(ERR_DB_INSERT, TBL_RECITALES_TO_LUGARVTA));
                    }
                }
            }
        }

        // Elimina los lugares asociados con un recital
        if( count($json->lugarvta_id_del)>0 ){
            $this->db->where_in('id', $json->lugarvta_id_del);
            $this->db->delete(TBL_RECITALES_TO_LUGARVTA);
        }

        // Vacia el/los campos image y elimina la imagen
        $data_imgdel = $json->images_del;
        if( count($data_imgdel->prefix)>0 ){
            $data3 = array();
            for( $n=0; $n<=count($data_imgdel->prefix)-1; $n++ ){
                $prefix = $data_imgdel->prefix[$n];
                if( !isset($data[$prefix."_thumb"]) ){
                    $data3[$prefix."_thumb"]="";
                    $data3[$prefix."_full"]="";
                }

                @unlink($data_imgdel->image_thumb[$n]);
                @unlink($data_imgdel->image_full[$n]);
            }
            if( count($data3)>0 ) $this->db->update(TBL_RECITALES, $data3);
        }

        return true;
    }
    
    public function delete($where){
        $this->db->select('image1_thumb,image2_thumb,image3_thumb,image4_thumb,image5_thumb,image1_full,image2_full,image3_full,image4_full,image5_full');
        $this->db->where_in(key($where), current($where));
        $query = $this->db->get(TBL_RECITALES);
        foreach( $query->result_array() as $row ){
            for( $n=1; $n<=5; $n++ ){
                $fn_image_thumb = $row['image'.$n.'_thumb'];
                $fn_image_full = $row['image'.$n.'_full'];
                if( $fn_image_thumb!="" ){
                    @unlink(UPLOAD_DIR.$fn_image_thumb);
                    @unlink(UPLOAD_DIR.$fn_image_full);
                }
            }
        }
        
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES.' WHERE '.key($where).' in('. implode(",", current($where)) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES));
        }
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES_TO_LUGARVTA.' WHERE '.key($where).' in('. implode(",", current($where)) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES_TO_LUGARVTA));
        }

        return true;
    }

    public function get_list($limit, $offset, $where=array()) {
        $sql = "name, genero,";
        $sql.= "(SELECT name FROM ".TBL_STATES." WHERE state_id=".TBL_BANDAS.".state_id) as state,";
        $sql.= "(SELECT name FROM ".TBL_CITY." WHERE state_id=".TBL_BANDAS.".state_id) as city";
        $ret = array();

        $this->db->select($sql, true);
        $this->db->where($where);
        $ret['count_rows'] = $this->db->count_all_results(TBL_BANDAS);

        $this->db->select($sql, true);
        $this->db->where($where);
        $this->db->order_by('bandas_id', 'desc');
        $ret['result'] = $this->db->get(TBL_BANDAS, $limit, $offset);

        return $ret;
    }

}
?>