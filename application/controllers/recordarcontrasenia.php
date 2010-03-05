<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recordarcontrasenia extends Controller {

    function __construct(){
        parent::Controller();
        $this->load->model('users_model');
        $this->load->library('email');
    }

    public function index(){
        $this->load->view('front_rememberpass_view');
    }

    public function send(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            
            $result = $this->users_model->rememberpass_generate_token(trim($_POST["txtField"]));

            if( $result ){
                $link = site_url('/recordarcontrasenia/password_reset/'.urlencode($result['username']).'/'.$result['token']);
                $message = sprintf(EMAIL_RP_MESSAGE,
                    $link,
                    $link
                );

                $this->email->from(EMAIL_RP_FROM, EMAIL_RP_NAME);
                $this->email->to($result['email']);
                $this->email->subject(EMAIL_RP_SUBJECT);
                $this->email->message($message);
                if( !$this->email->send() ){
                    $err = $this->email->print_debugger();
                    die($err);
                }else{
                    $this->load->view('front_rememberpass_view', array('status'=>"ok", 'field'=>$_POST['txtField']));
                }
            }
        }
    }

    public function password_reset(){
        $param1 = $this->uri->segment(3);
        $param2 = $this->uri->segment(4);

        if( $param1 && $param2 ){
            if( $this->users_model->check_token($param1, $param2) ){
                $this->load->view('front_passwordreset_view', array('username'=>$param1, 'token'=>$param2));
            }else redirect('/index/');
        }else redirect('/index/');
    }

    public function send_newpass(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            if( $this->users_model->change_pass($_POST) ){
                $this->load->library('encpss');
                $data = array(
                    'status'=>'ok',
                    'data'=>array(
                        'username'=>$this->encpss->encode($_POST['usr']),
                        'password'=>$this->encpss->encode($_POST['txtPass'])
                     )
                );
                $this->load->view('front_passwordreset_view', $data);
            }else redirect('/index/');
        }
    }

    public function ajax_check(){
        $this->load->library('captcha/securimage');

        $status = $this->users_model->rememberpass_check($_POST['field']);

        if( $status!="ok" ){
            die($status);
        }
        if( !empty($_POST['captcha']) ){
            if( !$this->securimage->check($_POST['captcha']) ){
                die("captcha_error");
            }
        }

        die("ok");
    }

}

?>