<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Controller();
        $this->load->model('lists_model');
        $this->load->model('destacados_model');

        $this->load->library('dataview', array(
            'listGeneros'  => $this->lists_model->get_generos(),
            'tlp_section' => 'frontpage/index_view.php',
            'tlp_title'   => TITLE_INDEX
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->_data = $this->dataview->set_data(array(
            'info' => $this->destacados_model->get_content(),
            'tlp_script' => array('twitter', 'imagegallery')
        ));
        $this->load->view('template_frontpage_view', $this->_data);
    }
    

}
?>
