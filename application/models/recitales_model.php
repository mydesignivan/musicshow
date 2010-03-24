<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class recitales_model extends Model {

    function  __construct() {
        parent::Model();
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function create($data = array()) {

        $lugarvta_id = $data['lugarvta_id'];
        unset($data['lugarvta_id']);

        if( !$this->db->insert(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_RECITALES));
        }
        
        $recital_id = $this->db->insert_id();

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

        return true;
    }

    public function edit($data = array(), $recital_id=null) {

        $lugarvta_id = $data['lugarvta_id'];
        $json = json_decode($data['json']);

        echo "<pre>";
        print_r($json);
        echo "</pre>";

        /*die();*/

        unset($data['lugarvta_id']);
        unset($data['json']);

        $this->db->where('recital_id', $recital_id);
        if( !$this->db->update(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_RECITALES));
        }

        $result_table = $this->db->get_where(TBL_RECITALES_TO_LUGARVTA, array('recital_id'=>$recital_id))->result_array();

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
    
    public function delete($id){
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES.' WHERE recital_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES));
        }
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES_TO_LUGARVTA.' WHERE recital_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES_TO_LUGARVTA));
        }

        return true;
    }

    public function get_list() {
        $sql = 'recital_id,';
        $sql.= 'banda,';
        $sql.= '`date`,';
        $sql.= "(SELECT name FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_name,";
        $sql.= "(SELECT address FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_address";

        $this->db->select($sql, false);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->order_by('recital_id', 'desc');
        $this->db->order_by('banda', 'asc');
        $query = $this->db->get(TBL_RECITALES);

        return $query;
    }

    public function get_list_paginator($limit, $offset, $where) {
        $sql = "SELECT * FROM (SELECT ";
        $sql.= 'recital_id,';
        $sql.= 'banda,';
        $sql.= '`date`,';
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
        $sql.= TBL_LUGARES .'.name as lugar_name,';
        $sql.= TBL_LUGARES .'.address as lugar_address';

        // Extrae datos del Recital
        $this->db->select($sql, false);
        $this->db->from(TBL_RECITALES);
        $this->db->join(TBL_LUGARES, TBL_RECITALES.'.lugar_id = '.TBL_LUGARES.'.lugar_id');
        $this->db->where('recital_id', $recital_id);

        $info = $query = $this->db->get()->row_array();

        // Extrae datos de los lugares de ventas
        $sql = TBL_LUGARES.'.lugar_id,';
        $sql.= TBL_LUGARES.'.name as lugar_name,';
        $sql.= TBL_LUGARES.'.address as lugar_address,';
        $sql.= TBL_RECITALES_TO_LUGARVTA.'.id';
        $this->db->select($sql, false);
        $this->db->from(TBL_LUGARES);
        $this->db->join(TBL_RECITALES_TO_LUGARVTA, TBL_LUGARES.'.lugar_id = '.TBL_RECITALES_TO_LUGARVTA.'.lugar_id');
        $this->db->where(TBL_RECITALES_TO_LUGARVTA.'.recital_id', $recital_id);

        $info['lugarvta'] = $this->db->get();

        return $info;
    }

    public function get_view_recital($recital_id) {
        $sql = TBL_RECITALES.'.*,';
        $sql.= TBL_LUGARES .'.name as lugar_name,';
        $sql.= TBL_LUGARES .'.address as lugar_address,';
        $sql.= "(SELECT name FROM ".TBL_GENEROS." WHERE genero_id = ".TBL_RECITALES.".genero_id) as genero_name,";
        $sql.= "(SELECT username FROM ".TBL_USERS." WHERE user_id = ".TBL_RECITALES.".user_id) as username";

        // Extrae datos del Recital
        $this->db->select($sql, false);
        $this->db->from(TBL_RECITALES);
        $this->db->join(TBL_LUGARES, TBL_RECITALES.'.lugar_id = '.TBL_LUGARES.'.lugar_id');
        $this->db->where('recital_id', $recital_id);

        $info = $query = $this->db->get()->row_array();

        // Extrae datos de los lugares de ventas
        $sql = TBL_LUGARES.'.lugar_id,';
        $sql.= TBL_LUGARES.'.name as lugar_name,';
        $sql.= TBL_LUGARES.'.address as lugar_address,';
        $sql.= TBL_RECITALES_TO_LUGARVTA.'.id';
        $this->db->select($sql, false);
        $this->db->from(TBL_LUGARES);
        $this->db->join(TBL_RECITALES_TO_LUGARVTA, TBL_LUGARES.'.lugar_id = '.TBL_RECITALES_TO_LUGARVTA.'.lugar_id');
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

    public function activate($user_id){
        $result = $this->db->get_where(TBL_USERS, array('user_id'=>$user_id));
        if( $result->num_rows>0 ) {
            $row = $result->row_array();

            if( $row['active']==1 ) return false;

            $this->db->where('user_id', $user_id);
            if( !$this->db->update(TBL_USERS, array('active'=>1)) ){
                show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
            }
            return $result;

        }else return false;

    }

    public function rememberpass($field){
        $result = $this->db->get_where(TBL_USERS, "(email = '".$field."' or username='".$field."') and active=0");
        if( $result->num_rows >0 ) return array("status"=>"userinactive");

        $result = $this->db->get_where(TBL_USERS, "(email = '".$field."' or username='".$field."') and active=1");
        if( $result->num_rows==0 ) return array("status"=>"notexists");

        $data = $result->row_array();
        $data['token'] = uniqid(time());

        $this->db->where('user_id', $data['user_id']);
        if( !$this->db->update(TBL_USERS, array('token'=>$data['token'])) ){
            show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
        }

        return array("status"=>"ok", "data"=>$data);
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