<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class users_model extends Model {

    function  __construct() {
        parent::Model();
        $this->load->library('encpss');
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function create($data = array()) {

        //Insert account into the database
        if( !$this->db->insert(TBL_USERS, $data) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_USERS));
        }

        return $this->db->insert_id();
    }

    public function modified($data = array(), $user_id=null) {

        if( empty($data["password"]) ) unset($data["password"]);

        //Update account into the database
        $this->db->where('user_id', $user_id);

        if( !$this->db->update(TBL_USERS, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
        }
        return true;
    }
    
    public function delete(){

    }

    public function get_user() {
        $query = $this->db->get_where(TBL_USERS, array('user_id'=>$this->session->userdata('user_id'), 'active'=>1));
        return $query->row_array();
    }

    public function check($username, $email, $user_id=''){
        if( $user_id=="" ){
            $where = array('username'=>$username);
            $where2 = array('email'=>$email);
        }else{
            $where = array('user_id <>'=>$user_id, 'username'=>$username);
            $where2 = array('user_id <>'=>$user_id, 'email'=>$email);
        }
        $result = $this->db->get_where(TBL_USERS, $where);
        if( $result->num_rows>0 ) return "existsuser";

        $result = $this->db->get_where(TBL_USERS, $where2);
        if( $result->num_rows>0 ) return "existsmail";

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

    public function rememberpass_generate_token($field){
        $result = $this->db->get_where(TBL_USERS, "(email = '".$field."' or username='".$field."') and active=1");
        $data = $result->row_array();
        $data['token'] = uniqid(time());

        $this->db->where('user_id', $data['user_id']);
        if( !$this->db->update(TBL_USERS, array('token'=>$data['token'])) ){
            show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
        }

        return $data;
    }

    public function rememberpass_check($field){
        $result = $this->db->get_where(TBL_USERS, "(email = '".$field."' or username='".$field."') and active=0");
        if( $result->num_rows >0 ) return "userinactive";

        $result = $this->db->get_where(TBL_USERS, "(email = '".$field."' or username='".$field."') and active=1");
        if( $result->num_rows==0 ) return "notexists";

        return "ok";
    }

    public function check_token($username, $token){
        $result = $this->db->get_where(TBL_USERS, array('username'=>$username, 'token'=>$token));
        return $result->num_rows>0;
    }

    public function change_pass($post){
        if( $this->check_token($post['usr'], $post['token']) ){
            $newpass = $this->encpss->encode($post['txtPass']);

            $this->db->where('username', $post['usr']);
            if( !$this->db->update(TBL_USERS, array('password'=>$newpass, 'token'=>'')) ){
                show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
            }
        }else return false;

        return true;
    }


}
?>