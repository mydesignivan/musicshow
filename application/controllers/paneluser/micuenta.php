<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Micuenta extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('users_model');
        $this->load->model('lists_model');
        $this->load->helper('form');
        $this->load->library('simplelogin');
        $this->load->library('encpss');
        $this->load->library('dataview', array(
            'tlp_section'  => 'paneluser/myaccount_view.php',
            'tlp_title'    => 'Mi Cuenta',
            'tlp_script'   => array('validator', 'popup', 'account')
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $info = $this->users_model->get_user();
        $this->_data = $this->dataview->set_data(array(
            'info'          =>  $info,
            'comboCountry'   =>  $this->lists_model->get_country(array("0"=>"Seleccione un Pa&iacute;s")),
            'comboStates'    =>  $this->lists_model->get_states(array("0"=>"Seleccione una Provincia"), $info['country_id'])
        ));

        $this->load->view("template_paneluser_view", $this->_data);
    }

    public function edit(){
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

            $status = $this->users_model->edit($data, $_POST["user_id"]);

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