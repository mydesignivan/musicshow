<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class lists_model extends Model {

    function  __construct() {
        parent::Model();
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function get_country($first_option){
        $this->db->select('name, country_id');
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_COUNTRY)->result_array();
        return array_merge($first_option, $array);
    }

    public function get_states($first_option, $country_id=null){
        if( is_numeric($first_option) ) $country_id = $first_option;
        $this->db->select('name, state_id');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_STATES)->result_array();
        if( is_array($first_option) ) $array = array_merge($first_option, $array);
        return $array;
    }

    public function get_city($first_option, $state_id=null){
        if( is_numeric($first_option) ) $state_id = $first_option;
        $this->db->select('name, city_id');
        $this->db->where('state_id', $state_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_CITY)->result_array();
        if( is_array($first_option) ) $array = array_merge($first_option, $array);
        return $array;
    }
    public function get_locality($first_option, $locality_id=null){
        if( is_numeric($first_option) ) $locality_id = $first_option;
        $this->db->select('name, locality_id');
        $this->db->where('locality_id', $locality_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_LOCALITY)->result_array();
        if( is_array($first_option) ) $array = array_merge($first_option, $array);
        return $array;
    }

    public function get_generos($first_option=null, $genero_id=null){
        $this->db->select('name, genero_id');
        if( $genero_id!=null ) $this->db->where('genero_id', $genero_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_GENEROS)->result_array();
        if( $first_option!=null ) $array = array_merge($first_option, $array);
        return $array;
    }

}
?>