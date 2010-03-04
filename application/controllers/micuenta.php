<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Micuenta extends Controller{
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('users_model');
        $this->load->model('lists_model');
        $this->load->library('simplelogin');
        $this->load->library('encpss');
        $this->load->helper('form');
    }

    public function index(){
        $info = $this->users_model->get_user();

        $listCountry = array();
        $listCountry = $this->lists_model->get_country()->result_array();
        $firstElement = array("0"=>"Seleccione un Pa&iacute;s");
        $listCountry = array_merge($firstElement, $listCountry);

        $listStates = array();
        $listStates = $this->lists_model->get_states($info['country_id'])->result_array();
        $firstElement = array("0"=>"Seleccione una Provincia");
        $listStates = array_merge($firstElement, $listStates);

        $data = array(
            'info'=>$info,
            'listCountry'=>$listCountry,
            'listStates'=>$listStates
        );

        $this->load->view("paneluser_myaccount_view", $data);
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