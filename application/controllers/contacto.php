<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends Controller {

    function __construct(){
        parent::Controller();
        $this->load->model('lists_model');
        $this->load->library('email');
    }

    public function index(){
        $data = array(
            'tlp_section'  => 'frontpage/contact_view.php',
            'tlp_script'   => 'front_contact',
            'tlp_title'    => TITLE_CONTACTO,
            'listGeneros'  => $this->lists_model->get_generos()
        );
        $this->load->view('template_view', $data);
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