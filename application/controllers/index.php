<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    private $_data;
    function  __construct() {
        parent::Controller();
        $this->load->library('dataview');
        
        $this->dataview->initializer('frontpage');
        $this->_data = $this->dataview->set_data(array(
            'tlp_section' => 'frontpage/index_view.php',
            'tlp_title'   => TITLE_INDEX
        ));
    }
	
    public function index(){
        $this->load->view('template_frontpage_view', $this->_data);
    }
    

}
?>