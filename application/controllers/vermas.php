<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Vermas extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Controller();
        $this->load->model('lists_model');
        $this->load->model('recitales_model');

        $this->load->library('dataview', array(
            'listGeneros'  => $this->lists_model->get_generos(),
            'tlp_section' => 'frontpage/viewmore_view.php',
            'tlp_script'  => 'fancybox',
            'tlp_title'   => TITLE_VERMAS
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        if( $this->uri->segment(3) ){
            $this->_data = $this->dataview->set_data(array(
                'info' => $this->recitales_model->get_recital($this->uri->segment(3))
            ));
            $this->load->view('template_frontpage_view', $this->_data);
        }
    }    

}
?>
