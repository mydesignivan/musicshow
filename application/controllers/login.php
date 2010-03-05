<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Controller{

    function __construct(){
        parent::Controller();
        $this->load->library('simplelogin');
    }

    public function index(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $statusLogin = $this->simplelogin->login($_POST["txtLoginUser"], $_POST["txtLoginPass"]);
            

            if( $statusLogin['error'] ){
                $this->session->set_flashdata('statusLogin', $statusLogin['message']);
                redirect('/index/');
            }else{
                if( $this->session->userdata('level')==0 ){
                    redirect('/index/');
                }else{
                    redirect('/inicio/');
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
                redirect('/panel/micuenta/');
            }
        }
    }

}

?>
