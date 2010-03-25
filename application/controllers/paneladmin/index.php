<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==0 ) redirect('/index/');
        
        $this->load->model('content_model');
        $this->load->library('dataview');

        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->_data = $this->dataview->set_data(array(
            'tlp_section'  => 'paneladmin/index_view.php',
            'tlp_title'    => 'Inicio',
            'tlp_script'   => 'editor_tinymce',
            'info'         => $this->content_model->get_content()
        ));
        $this->load->view("template_paneladmin_view", $this->_data);
    }

    public function save(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->content_model->save($_POST['txtContent']);
            redirect('/paneladmin/index/');
        }
    }

}

?>