<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('recitales_model');
        $this->load->model('lists_model');
        $this->load->helper('form');
    }

    public function index(){
        $list = $this->recitales_model->get_list();
        $this->load->view("paneluser_recitales_view", array('listRecitales'=>$list));
    }
    public function form(){
        $info = is_numeric($this->uri->segment(4)) ? $this->recitales_model->get_recital($this->uri->segment(4)) : false;

        $listGeneros = array();
        $listGeneros = $this->lists_model->get_generos()->result_array();
        $firstElement = array("0"=>"Seleccione un Genero");
        $listGeneros = array_merge($firstElement, $listGeneros);

        $this->load->view("paneluser_recitalesform_view", array('info'=>$info, 'listGeneros'=>$listGeneros));
    }

    public function save(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            $data = $this->request_fields();
            $data = array_merge(array('user_id'=>$this->session->userdata('user_id'), 'date_added'=>date('Y-m-d h:i:s')), $data);

            $this->recitales_model->create($data);
            redirect('/panel/recitales/');
        }
    }

    public function edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            $data = $this->request_fields();
            $data = array_merge(array('last_modified'=>date('Y-m-d h:i:s')), $data);

            $this->recitales_model->modified($data, $_POST['recital_id']);
            redirect('/panel/recitales/');
        }
    }
    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            if( $this->recitales_model->delete($id) ){
                redirect('/panel/recitales/');
            }else{
                show_error(ERR_RECITAL_DELETE);
            }
        }
    }

    public function ajax_check(){
        echo $this->recitales_model->check($_POST['banda'], $_POST['recitalid']);
        die();
    }

    /*
     * FUNCTIONS PRIVATE
     */
    private function request_fields(){
        return array(
            'banda'         => $_POST['txtBanda'],
            'genero_id'     => $_POST['cboGenero'],
            'date'          => $_POST['txtDate'],
            'place'         => $_POST['txtPlace'],
            'place2'        => $_POST['txtPlace2'],
            'price'         => $_POST['txtPrice'],
            'price2'        => $_POST['txtPrice2']
        );
    }

}

?>