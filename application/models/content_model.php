<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class content_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function save($content) {

        if( !$this->db->update(TBL_CONTENT, array('content'=>$content)) ) {
            show_error(sprintf(ERR_DB_INSERT, TBL_CONTENT));
        }
        
        return true;
    }

    public function get_content(){
        return $this->db->get(TBL_CONTENT)->row_array();
    }

}
?>