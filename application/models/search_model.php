<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class search_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function search($limit, $offset, $where) {
        $sql = "SELECT * FROM (SELECT ";
        $sql.= 'recital_id,';
        $sql.= 'genero_id,';
        $sql.= "(SELECT name FROM ".TBL_GENEROS." WHERE genero_id=".TBL_RECITALES.".genero_id) AS genero,";
        $sql.= 'banda,';
        $sql.= '`date`,';
        $sql.= '`image1_thumb`,';
        $sql.= '`image1_full`,';
        $sql.= "(SELECT lc.name FROM list_city lc JOIN lugares l ON lc.city_id = l.city_id WHERE l.lugar_id = ".TBL_RECITALES.".lugar_id) as city,";
        $sql.= "(SELECT name FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_name,";
        $sql.= "(SELECT address FROM ".TBL_LUGARES.' WHERE lugar_id='.TBL_RECITALES.".lugar_id) as lugar_address ";
        $sql.= "FROM ".TBL_RECITALES.") a WHERE ";

        $arr_where = array();
        if( !empty($where['genero']) ) $arr_where[] = "genero_id = ".$where['genero'];
        if( !empty($where['keyword']) ) $arr_where[] = "banda LIKE '%".$where['keyword']."%' OR lugar_name LIKE '%".$where['keyword']."%' OR lugar_address LIKE '%".$where['keyword']."%'";
        if( !empty($where['date']) ) $arr_where[] = "date = '".$where['date']."'";
        
        $sql.= implode(" AND ", $arr_where);
        $sql.= " ORDER BY recital_id desc ";

        //die($sql);

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

}
?>