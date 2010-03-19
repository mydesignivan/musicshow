<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Registro extends Controller {

    private $_data;
    function  __construct() {
        parent::Controller();
        $this->load->model('users_model');
        $this->load->model('lists_model');
        $this->load->helper('form');
        $this->load->library('encpss');
        $this->load->library('email');
        $this->load->library('dataview');

        $this->dataview->initializer('frontpage');
        $this->_data = $this->dataview->set_data(array(
            'tlp_section'  => 'frontpage/registro_view.php',
            'tlp_script'   => array('validator', 'account'),
            'tlp_title'    => TITLE_REGISTRO,
            'comboCountry' => $this->lists_model->get_country(array("0"=>"Seleccione un Pa&iacute;s")),
        ));
    }

    /*
     * FUNCTIONS PUBLIC
     */
    public function index(){
        $this->load->view('template_frontpage_view', $this->_data);
    }

    public function create(){
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
                'date_added'    => date('Y-m-d h:i:s')
            );

            $user_id = $this->users_model->create($data);

            $link = site_url('/registro/confirm_email/'.$this->encpss->urlsafe_base64_encode($user_id));
            $message = sprintf(EMAIL_REG_MESSAGE,
                $_POST['txtUser'],
                $link,
                $link
            );

            $this->email->from(EMAIL_REG_FROM, EMAIL_REG_NAME);
            $this->email->to($_POST["txtEmail"]);
            $this->email->subject(EMAIL_REG_SUBJECT);
            $this->email->message($message);
            if( $this->email->send() ){
                $this->session->set_flashdata('statusrecord', 'saveok');
                $this->session->set_flashdata('name', $_POST['txtUser']);
                $this->session->set_flashdata('email', $_POST["txtEmail"]);
                redirect('/registro/');
            }else {
                $err = $this->email->print_debugger();
                die($err);
            }
        }        
    }

    public function confirm_email(){
        if( $this->uri->segment(3) ){
            $seg = $this->encpss->urlsafe_base64_decode($this->uri->segment(3));
            $res = $this->users_model->activate($seg);
            if( !$res ){
                redirect('/index/');
            }else{
                $user = $res->row_array();
                $message = sprintf(EMAIL_REGACTIVE_MESSAGE,
                    $user['username'],
                    $user['username'],
                    $this->encpss->decode($user['password'])
                );

                $this->email->from(EMAIL_REGACTIVE_FROM, EMAIL_REGACTIVE_NAME);
                $this->email->to($user['email']);
                $this->email->subject(EMAIL_REGACTIVE_SUBJECT);
                $this->email->message($message);
                if( $this->email->send() ){
                    $this->_data = $this->dataview->set_data(array(
                        'tlp_section'   =>  'frontpage/useractivation_view.php',
                        'tlp_script'    =>  '',
                        'username'      =>  $user['username']
                    ));
                    $this->load->view('template_frontpage_view', $this->_data);
                }else {
                    $err = $this->email->print_debugger();
                    die($err);
                }

            }
        }else redirect('/index/');
    }

    public function ajax_show_states(){
        $comboStates = $this->lists_model->get_states($this->uri->segment(3));
        echo '<option value="0">Seleccione una Provincia</option>\n';
        foreach( $comboStates as $row ){
            echo '<option value="'.$row['state_id'].'">'.$row['name'].'</option>\n';
        }
        die();
    }

    public function ajax_check(){
        $this->load->library('captcha/securimage');

        $status = $this->users_model->check($_POST['username'], $_POST['email'], $_POST['userid']);
        
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

    /*
     * FUNCTIONS PRIVATE
     */

}
?>