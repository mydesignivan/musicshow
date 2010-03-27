<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        $this->load->library('simplelogin');
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            //print_array($_POST);

            $statusLogin = $this->simplelogin->login($_POST["txtLoginUser"], $_POST["txtLoginPass"]);

            if( $statusLogin['status']=="error" ){
                $this->session->set_flashdata('error_login', $statusLogin['error']);
                redirect('/index/');
            }else{
                if( $this->session->userdata('level')==0 ){
                    redirect('/index/');
                }else{
                    redirect('/paneladmin/index/');
                }
            }

        }
    }

    public function logout(){
        $this->simplelogin->logout();
        redirect('/index/');
    }

    public function account_access(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $this->load->library('encpss');
            if( $this->simplelogin->login($this->encpss->decode($_POST["p1"]), $this->encpss->decode($_POST["p2"])) ){
                redirect('/paneluser/micuenta/');
            }
        }
    }

}

?>
