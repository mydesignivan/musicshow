<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        //$this->load->model('recitales_model');
        $this->load->helper('form');
    }

    public function index(){
        $this->load->view("paneluser_recitales_view");
    }
    public function form(){
        $this->load->view("paneluser_recitalesform_view", $data);
    }

    public function save(){
    }
    public function modified(){
    }
    public function delete(){
    }

}

?>