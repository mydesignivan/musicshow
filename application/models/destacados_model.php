<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class destacados_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function create($data = array()) {

        //Insert account into the database
        if( !$this->db->insert(TBL_DESTACADOS, $data) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_DESTACADOS));
        }

        return $this->db->insert_id();
    }

    public function edit($data = array(), $destacado_id=null) {

        //Update account into the database
        $this->db->where('destacado_id', $destacado_id);

        if( !$this->db->update(TBL_DESTACADOS, $data) ) {
            show_error(sprintf(ERR_DB_UPDATE, TBL_DESTACADOS));
        }
        return true;
    }
    
    public function delete($id){
        if( !$this->db->query('DELETE FROM '.TBL_DESTACADOS.' WHERE destacado_id in('. implode(",", $id) .')') ){
            show_error(sprintf(ERR_DB_DELETE, TBL_DESTACADOS));
        }

        return true;
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
        $sql = 'destacado_id,';
        $sql.= 'banda,';
        $sql.= 'description';
        /*if( count($where)>0 ){
            $field = key($where);
            $search = current($where);
            $sql.= "AND $field LIKE '%$search%' ";
        }*/
        $this->db->select($sql, false);
        $query = $this->db->get(TBL_DESTACADOS);
        $count_rows = $query->num_rows;

        $this->db->select($sql, false);
        $this->db->order_by('destacado_id', 'desc');
        $query = $this->db->get(TBL_DESTACADOS, $limit, $offset);

        return array(
            'result'     => $query,
            'count_rows' => $count_rows
        );
    }

    public function check($recital_id){
        $result = $this->db->get_where(TBL_DESTACADOS, array('recital_id'=>$recital_id));
        if( $result->num_rows>0 ) return "existsuser";

        return "ok";
    }


}
?>