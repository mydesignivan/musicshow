<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class recitales_model extends Model {

    function  __construct() {
        parent::Model();
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function create($data = array()) {

        //Insert account into the database
        if( !$this->db->insert(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_RECITALES));
        }

        return $this->db->insert_id();
    }

    public function modified($data = array(), $recital_id=null) {

        //Update account into the database
        $this->db->where('recital_id', $recital_id);

        if( !$this->db->update(TBL_RECITALES, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_RECITALES));
        }
        return true;
    }
    
    public function delete($id){
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES.' WHERE recital_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES));
        }
        return true;
    }

    public function get_list() {
        $this->db->where(array('user_id'=>$this->session->userdata('user_id')));
        $this->db->order_by('recital_id', 'desc');
        $this->db->order_by('banda', 'asc');
        $query = $this->db->get(TBL_RECITALES);
        return $query;
    }

    public function get_recital($recital_id) {
        $query = $this->db->get_where(TBL_RECITALES, array('recital_id'=>$recital_id));
        return $query->row_array();
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
        $this->db->where('city_id', $city_id);
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_LUGARES)->result_array();
    }

    public function save_lugares(){
        $data = array(
            'name'      =>  urldecode($_POST['name']),
            'city_id'   =>  $_POST['city_id']
        );
        if( !$this->db->insert(TBL_LUGARES, $data) ){
            show_error(sprintf(ERR_DB_INSERT, TBL_LUGARES));
        }
        return true;
    }
    public function delete_lugar($lugar_id){
        $this->db->where('lugar_id', $lugar_id);
        if( !$this->db->delete(TBL_LUGARES) ){
            show_error(sprintf(ERR_DB_DELETE, TBL_LUGARES));
        }
        return true;
    }

}
?>