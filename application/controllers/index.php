<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends Controller {

    function  __construct() {
        parent::Controller();
        $this->load->model('lists_model');
    }
	
    public function index(){
        $data = array(
            'tlp_section' => 'frontpage/index_view.php',
            'tlp_title'   => TITLE_INDEX,
            'listGeneros' => $this->lists_model->get_generos()
        );
        $this->load->view('template_view', $data);
    }
    

}
?>