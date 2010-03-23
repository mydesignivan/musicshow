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

    public function edit($data = array(), $user_id=null) {

        if( empty($data["password"]) ) unset($data["password"]);

        //Update account into the database
        $this->db->where('user_id', $user_id);

        if( !$this->db->update(TBL_USERS, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_USERS));
        }
        return true;
    }
    
    public function delete($id){
        if( !$this->db->query('DELETE FROM '.TBL_USERS.' WHERE user_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_USERS));
        }
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES.' WHERE user_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES));
        }
        if( !$this->db->query('DELETE FROM '.TBL_RECITALES_TO_LUGARVTA.' WHERE user_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_RECITALES_TO_LUGARVTA));
        }

        return true;
    }

    public function get_user() {
        $query = $this->db->get_where(TBL_USERS, array('user_id'=>$this->session->userdata('user_id'), 'active'=>1));
        return $query->row_array();
    }
    
    public function get_user_view($user_id) {
        $sql = "username,";
        $sql.= "CONCAT(firstname,', ',lastname) as name,";
        $sql.= "CONCAT('(',phone_area,') ',phone) as phone,";
        $sql.= "email,";
        $sql.= "city,";
        $sql.= "address,";
        $sql.= "newsletter,";
        $sql.= "(SELECT name FROM ".TBL_COUNTRY." WHERE country_id=".TBL_USERS.".country_id) as country,";
        $sql.= "(SELECT name FROM ".TBL_STATES." WHERE state_id=".TBL_USERS.".state_id) as state ";

        $this->db->select($sql, false);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get(TBL_USERS);
        return $query->row_array();
    }

    public function get_list_paginator($limit, $offset, $where) {
        $sql = "SELECT * FROM (SELECT ";
        $sql.= 'user_id,';
        $sql.= 'username,';
        $sql.= 'active,';
        $sql.= 'level,';
        $sql.= "CONCAT(firstname, ', ', lastname) AS name ";
        $sql.= "FROM ".TBL_USERS.") a WHERE level=0 ";
        if( count($where)>0 ){
            $field = key($where);
            $search = current($where);
            $sql.= "AND $field LIKE '%$search%' ";
        }
        $sql.= "ORDER BY user_id desc ";

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