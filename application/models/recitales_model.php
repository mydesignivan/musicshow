<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class recitales_model extends Model {

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

    public function get_list() {
        $sql = 'recital_id,';
        $sql.= 'banda,';
        $sql.= "REPLACE(`date`, CHAR(44), '/') as `date`,";
        $sql.= "(SELECT name FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_name,";
        $sql.= "(SELECT address FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_address";

        $this->db->select($sql, false);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->order_by("str_to_date(`date`, '%d,%m,%Y')", 'desc');
        $query = $this->db->get(TBL_RECITALES);

        return $query;
    }

    public function get_list_paginator($limit, $offset, $where) {
        $sql = "SELECT * FROM (SELECT ";
        $sql.= 'recital_id,';
        $sql.= 'banda,';
        $sql.= "REPLACE(`date`, CHAR(44), '/') as `date`,";
        $sql.= "(SELECT name FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_name,";
        $sql.= "(SELECT address FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_address ";
        $sql.= "FROM ".TBL_RECITALES.") a ";
        if( count($where)>0 ){
            $field = key($where);
            $search = current($where);

            if( $field=="date" ) {
                $search = str_replace("-", "/", $search);
            }

            $sql.= "WHERE $field LIKE '%$search%' ";
        }
        $sql.= "ORDER BY recital_id desc, banda asc ";

        $query = $this->db->query($sql);
        $count_rows = $query->num_rows;

        $sql.= "LIMIT $limit";
        if( $offset!=0 ) $sql.=",$offset";

        $query = $this->db->query($sql);

        return array(
            'result'     => $query,
            'count_rows' => $count_rows
        );
    }

    public function get_recital($recital_id) {
        $sql = TBL_RECITALES.'.*,';
        $sql.= "REPLACE(".TBL_RECITALES.".`date`, CHAR(44), '/') as `date`,";
        $sql.= TBL_LUGARES .'.name as lugar_name,';
        $sql.= TBL_LUGARES .'.address as lugar_address,';
        $sql.= TBL_STATES .'.name as lugar_state,';
        $sql.= TBL_CITY .'.name as lugar_city,';
        $sql.= "(SELECT name FROM ".TBL_GENEROS." WHERE genero_id = ".TBL_RECITALES.".genero_id) as genero_name,";
        $sql.= "(SELECT username FROM ".TBL_USERS." WHERE user_id = ".TBL_RECITALES.".user_id) as username";

        // Extrae datos del Recital
        $this->db->select($sql, false);
        $this->db->from(TBL_RECITALES);
        $this->db->join(TBL_LUGARES, TBL_RECITALES.'.lugar_id = '.TBL_LUGARES.'.lugar_id');
        $this->db->join(TBL_CITY, TBL_LUGARES.'.city_id = '.TBL_CITY.'.city_id');
        $this->db->join(TBL_STATES, TBL_CITY.'.state_id = '.TBL_STATES.'.state_id');
        $this->db->where('recital_id', $recital_id);

        $info = $query = $this->db->get()->row_array();

        if( !is_null($info['timer']) ){
            $info['timer_hour'] = date('H', strtotime($info['timer']));
            $info['timer_minute'] = date('i', strtotime($info['timer']));
        }

        // Extrae datos de los lugares de ventas
        $sql = TBL_LUGARES.'.lugar_id,';
        $sql.= TBL_LUGARES.'.name as lugar_name,';
        $sql.= TBL_LUGARES.'.address as lugar_address,';
        $sql.= TBL_STATES .'.name as lugar_state,';
        $sql.= TBL_CITY .'.name as lugar_city,';
        $sql.= TBL_RECITALES_TO_LUGARVTA.'.id';
        $this->db->select($sql, false);
        $this->db->from(TBL_LUGARES);
        $this->db->join(TBL_RECITALES_TO_LUGARVTA, TBL_LUGARES.'.lugar_id = '.TBL_RECITALES_TO_LUGARVTA.'.lugar_id');
        $this->db->join(TBL_CITY, TBL_LUGARES.'.city_id = '.TBL_CITY.'.city_id');
        $this->db->join(TBL_STATES, TBL_CITY.'.state_id = '.TBL_STATES.'.state_id');
        $this->db->where(TBL_RECITALES_TO_LUGARVTA.'.recital_id', $recital_id);

        $info['lugarvta'] = $this->db->get();

        return $info;
    }

    public function get_count_recitales(){
        $this->db->where(array('user_id'=>$this->session->userdata('user_id')));
        return $this->db->get(TBL_RECITALES)->num_rows;
    }

    public function check($banda, $recital_id=''){
        if( $recital_id=="" ){
            $where = array('banda'=>$banda);
        }else{
            $where = array('recital_id <>'=>$recital_id, 'banda'=>$banda);
        }
        $result = $this->db->get_where(TBL_RECITALES, $where);
        if( $result->num_rows>0 ) return "exists";

        return "ok";
    }

    public function list_lugares($city_id){
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('city_id', $city_id);
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_LUGARES)->result_array();
    }

    public function save_lugares(){
        $data = array(
            'user_id'  =>  $this->session->userdata('user_id'),
            'name'     =>  urldecode($_POST['name']),
            'address'  =>  urldecode($_POST['address']),
            'city_id'  =>  $_POST['id']
        );
        if( !$this->db->insert(TBL_LUGARES, $data) ){
            show_error(sprintf(ERR_DB_INSERT, TBL_LUGARES));
        }
        return true;
    }
    public function delete_lugar($lugar_id){

        // Verifica si existe en la tabla Recitales
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('lugar_id', $lugar_id);
        $query = $this->db->get(TBL_RECITALES);
        if( $query->num_rows>0 ){
            $data = "";
            foreach( $query->result_array() as $row ) $data.= $row['banda']."\n";
            return array(
                'status' => 'exists_recitales',
                'data' => $data
            );
        }

        // Verifica si existe en los lugares de venta
        $this->db->select(TBL_RECITALES.".banda");
        $this->db->from(TBL_RECITALES);
        $this->db->join(TBL_RECITALES_TO_LUGARVTA, TBL_RECITALES.'.recital_id = '.TBL_RECITALES_TO_LUGARVTA.".recital_id");
        $this->db->join(TBL_LUGARES, TBL_RECITALES_TO_LUGARVTA.".lugar_id = ".TBL_LUGARES.'.lugar_id');
        $this->db->where(TBL_RECITALES.'.user_id', $this->session->userdata('user_id'));
        $this->db->where(TBL_LUGARES.'.lugar_id', $lugar_id);
        $query = $this->db->get();
        if( $query->num_rows>0 ){
            $data = "";
            foreach( $query->result_array() as $row ) $data.= $row['banda']."\n";
            return array(
                'status' => 'exists_lugarvta',
                'data' => $data
            );
        }

        $this->db->where('lugar_id', $lugar_id);
        if( !$this->db->delete(TBL_LUGARES) ){
            show_error(sprintf(ERR_DB_DELETE, TBL_LUGARES));
        }
        return array('status'=>'ok');
    }

}
?>