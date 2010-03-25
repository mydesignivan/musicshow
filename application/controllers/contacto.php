<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        $this->load->library('email');
        $this->load->model('lists_model');

        $this->load->library('dataview', array(
            'listGeneros'  => $this->lists_model->get_generos(),
            'tlp_section'  => 'frontpage/contact_view.php',
            'tlp_script'   => array('validator', 'contact'),
            'tlp_title'    => TITLE_CONTACTO
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->load->view('template_frontpage_view', $this->_data);
    }

    public function send(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            $message = sprintf(EMAIL_CONTACT_MESSAGE,
                    $_POST['txtName'],
                    $_POST['txtEmail'], 
                    $_POST['txtPhone'], 
                    $_POST['txtState'],
                    $_POST['txtCity'], 
                    nl2br($_POST['txtConsult'])
            );

            $this->email->from($_POST['txtEmail'], $_POST['txtName']);
            $this->email->to($_POST['cboArea']);
            $this->email->subject(EMAIL_CONTACT_SUBJECT);
            $this->email->message($message);
            if( $this->email->send() ){
                $this->session->set_flashdata('statusmail', 'ok');
            }else {
                $err = $this->email->print_debugger();
                die($err);
            }
            redirect('/contacto/');
        }
    }
}

?>