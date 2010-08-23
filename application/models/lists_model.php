<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class lists_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
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
        $sql = "name, genero_id,";
        $sql.= "(SELECT count(*) FROM ".TBL_RECITALES." WHERE genero_id=".TBL_GENEROS.".genero_id AND str_to_date(`date`, '%d,%m,%Y') >= current_date()) as count_recitales";

        $this->db->select($sql, false);
        if( $genero_id!=null ) $this->db->where('genero_id', $genero_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get(TBL_GENEROS)->result_array();
        if( $first_option!=null ) $array = array_merge($first_option, $array);
        return $array;
    }

    public function get_filter_states($first_option, $genero){
        $this->db->select("DISTINCT ".TBL_STATES.'.name, '.TBL_STATES.".state_id", false);
        $this->db->from(TBL_STATES);
        $this->db->join(TBL_CITY, TBL_STATES.'.state_id = '.TBL_CITY.'.state_id');
        $this->db->join(TBL_LUGARES, TBL_CITY.'.city_id = '.TBL_LUGARES.'.city_id');
        $this->db->join(TBL_RECITALES, TBL_LUGARES.'.lugar_id = '.TBL_RECITALES.'.lugar_id');
        $this->db->where("str_to_date(".TBL_RECITALES.".`date`, '%d,%m,%Y') >=", "current_date()");
        $this->db->where(TBL_RECITALES.".genero_id", $genero);
        $array = $this->db->get()->result_array();
        if( is_array($first_option) ) $array = array_merge($first_option, $array);
        return $array;
    }

    public function get_filter_city($param, $genero, $state_id=null){
        $this->db->select("DISTINCT ".TBL_CITY.'.name, '.TBL_CITY.".city_id", false);
        $this->db->from(TBL_CITY);
        $this->db->join(TBL_LUGARES, TBL_CITY.'.city_id = '.TBL_LUGARES.'.city_id');
        $this->db->join(TBL_RECITALES, TBL_LUGARES.'.lugar_id = '.TBL_RECITALES.'.lugar_id');
        $this->db->where("str_to_date(".TBL_RECITALES.".`date`, '%d,%m,%Y') >=", "current_date()");
        $this->db->where(TBL_RECITALES.".genero_id", $genero);
        if( !is_null($state_id) ) $this->db->where(TBL_CITY.".state_id = ".$state_id);
        $this->db->order_by('name', 'asc');
        $array = $this->db->get()->result_array();
        if( is_array($param) ) $array = array_merge($param, $array);

        return $array;
    }

    public function get_value($table, $where){
        $query = $this->db->get_where($table, $where);
        if( $query->num_rows > 0 ) {
            $row = $query->row_array();
            return $row['name'];
        }else return false;
    }

}
?>