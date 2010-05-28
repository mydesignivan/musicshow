<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class search_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function search($where, $orderby=null, $limit=null, $offset=null) {
        $sql = "SELECT * FROM (SELECT ";
        $sql.= 'recital_id,';
        $sql.= 'genero_id,';
        $sql.= "(SELECT name FROM ".TBL_GENEROS." WHERE genero_id=".TBL_RECITALES.".genero_id) AS genero,";
        $sql.= 'banda,';
        $sql.= "`date`,";
        $sql.= '`image1_thumb`,';
        $sql.= '`image1_full`,';
        $sql.= "(SELECT lc.name FROM list_city lc JOIN lugares l ON lc.city_id = l.city_id WHERE l.lugar_id = ".TBL_RECITALES.".lugar_id) as city,";
        $sql.= "(SELECT lc.city_id FROM list_city lc JOIN lugares l ON lc.city_id = l.city_id WHERE l.lugar_id = ".TBL_RECITALES.".lugar_id) as city_id,";
        $sql.= "(SELECT lc.state_id FROM list_city lc JOIN lugares l ON lc.city_id = l.city_id WHERE l.lugar_id = ".TBL_RECITALES.".lugar_id) as state_id,";
        $sql.= "(SELECT name FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_name,";
        $sql.= "(SELECT address FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_address ";
        $sql.= "FROM ".TBL_RECITALES.") a ";
        $sql.= "WHERE str_to_date(`date`, '%d,%m,%Y') >= current_date() AND ";

        $arr_where = array();
        if( !empty($where['genero']) ) $arr_where[] = "genero_id = ".$where['genero'];
        if( !empty($where['keyword']) ) $arr_where[] = "banda LIKE '%".$where['keyword']."%' OR lugar_name LIKE '%".$where['keyword']."%' OR lugar_address LIKE '%".$where['keyword']."%' OR city LIKE '%".$where['keyword']."%'";
        if( !empty($where['date']) ) $arr_where[] = $where['date'];
        if( !empty($where['state']) ) $arr_where[] = "state_id = ".$where['state'];
        if( !empty($where['city']) ) $arr_where[] = "city_id = ".$where['city'];
        
        $sql.= implode(" AND ", $arr_where);
        $sql.= " ORDER BY ";

        if( $orderby==null ) $sql.= "str_to_date(`date`, '%d,%m,%Y') desc";
        else $sql.= $orderby;

        //die($sql);

        $return = array();

        if( is_numeric($limit) && is_numeric($offset) ){
            $query = $this->db->query($sql);
            $return['count_rows'] = $query->num_rows;

            if( $offset==0 ) {
                $sql.= " LIMIT $limit";
            }else{
                $sql.= " LIMIT $offset,$limit";
            }

            //echo $sql."<br>";
        }


        $return['result'] = $this->db->query($sql);

        return $return;
    }

    public function search_in_all_months(){
    }

}
?>