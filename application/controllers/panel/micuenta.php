<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Micuenta extends Controller{
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('users_model');
        $this->load->model('lists_model');
        $this->load->library('simplelogin');
        $this->load->library('encpss');
        $this->load->library('dataview');
        $this->load->helper('form');

        $this->dataview->initializer('frontpage');
        $this->_data = $this->dataview->set_data(array(
            'tlp_section'  => 'paneluser/myaccount_view.php',
            'tlp_title'    => 'Mi Cuenta',
            'tlp_script'   => array('validator', 'account')
        ));

    }

    public function index(){
        $info = $this->users_model->get_user();
        $this->_data = $this->dataview->set_data(array(
            'info'          =>  $info,
            'listCountry'   =>  $this->lists_model->get_country(array("0"=>"Seleccione un Pa&iacute;s")),
            'listStates'    =>  $this->lists_model->get_states(array("0"=>"Seleccione una Provincia"), $info['country_id'])->result_array()
        ));

        $this->load->view("template_paneluser_view", $this->_data);
    }

    public function modified(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            
            $data = array(
                'email'         => $_POST['txtEmail'],
                'username'      => $_POST['txtUser'],
                'password'      => $this->encpss->encode($_POST["txtPass"]),
                'newsletter'    => empty($_POST['chkNewsletter']) ? "0" : $_POST['chkNewsletter'],
                'lastname'      => $_POST['txtLastName'],
                'firstname'     => $_POST['txtFirstName'],
                'country_id'    => $_POST['cboCountry'],
                'state_id'      => $_POST['cboStates'],
                'city'          => $_POST['txtCity'],
                'phone_area'    => $_POST['txtPhoneArea'],
                'phone'         => $_POST['txtPhone'],
                'address'       => $_POST['txtAddress'],
                'last_modified' => date('Y-m-d h:i:s')
            );

            $status = $this->users_model->modified($data, $_POST["user_id"]);

            if( $status ){
                $this->simplelogin->logout();
                redirect('/index/');
            }else{
                show_error(ERR_USER_EDIT);
            }

        }
    }

}

?>