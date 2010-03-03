<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Registro extends Controller {

    function  __construct() {
        parent::Controller();
        $this->load->helper('form');
        $this->load->model('lists_model');
    }
	
    function index(){
        $listCountry = array();
        $listCountry = $this->lists_model->get_country()->result_array();
        $listCountry[] = array("name"=>"Seleccione un Pa&iacute;s", "id"=>"0");
        $this->load->view('registro_view', array('listCountry'=>$listCountry));
    }

    function ajax_show_states(){
        $listStates = $this->lists_model->get_states($_GET['country_id']);
        echo json_encode($listStates->result_array());
        die();
    }
    

}
?>