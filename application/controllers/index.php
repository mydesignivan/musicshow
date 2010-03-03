<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    function  __construct() {
        parent::Controller();
    }
	
    function index(){
        $this->load->view('index_view');
    }
    

}
?>