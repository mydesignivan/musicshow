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

    public function get_states($country_id){
        $this->db->select('name, state_id');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_STATES);
    }

    public function get_generos($genero_id=null){
        $this->db->select('name, genero_id');
        if( $genero_id!=null ) $this->db->where('genero_id', $genero_id);
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_GENEROS);
    }

}
?>