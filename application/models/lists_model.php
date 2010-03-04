<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class lists_model extends Model {

    function  __construct() {
        parent::Model();
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function get_country(){
        $this->db->select('name, country_id');
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_COUNTRY);
    }
    public function get_states($country_id){
        $this->db->select('name, state_id');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('name', 'asc');
        return $this->db->get(TBL_STATES);
    }

}
?>