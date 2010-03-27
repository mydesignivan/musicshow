<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==0 ) redirect('/index/');
        
        $this->load->model('recitales_model');
        $this->load->library('pagination');
        $this->load->library('dataview', array(
            'tlp_section'  => 'paneladmin/recitales_list_view.php',
            'tlp_title'    => 'Recitales'
        ));

        $this->_data = $this->dataview->get_data();
        $this->count_per_page=10;
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;
    private $count_per_page;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->_display(array());
    }

    public function view(){
        $info = $this->recitales_model->get_recital($this->uri->segment(4));

        $this->_data = $this->dataview->set_data(array(
            'tlp_section'   => 'paneladmin/recitales_view_view.php',
            'tlp_title'     => 'Recital Detalle',
            'listRecitales' => null,
            'info'          => $info
        ));
        $this->load->view("template_paneladmin_view", $this->_data);
    }

    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            if( $this->recitales_model->delete(array('recital_id'=>$id)) ){
                redirect('/paneladmin/recitales/');
            }else{
                show_error(ERR_RECITAL_DELETE);
            }
        }
    }

    public function search(){
        $seg1 = $this->uri->segment(4);
        $seg2 = $this->uri->segment(5);
        if( $seg1 && $seg2 ){
            $this->_display(array($seg1=>$seg2));
        }
    }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _display($where){
        if( count($where)==0 ){
            $base_url = site_url('/paneladmin/recitales/index/');
            $uri_segment = 4;

        }else{
            $base_url = site_url('/paneladmin/recitales/search/'.key($where)."/".current($where));
            $uri_segment = 6;
        }

        $offset = !is_numeric($this->uri->segment($uri_segment)) ? 0 : $this->uri->segment($uri_segment);
        $listRecitales = $this->recitales_model->get_list_paginator($this->count_per_page, $offset, $where);

        $this->_data = $this->dataview->set_data(array(
            'tlp_script'    => 'recitales_list',
            'listRecitales' =>  $listRecitales['result']
        ));

        $config['base_url'] = str_replace(".html", "", $base_url);
        $config['total_rows'] = $listRecitales['count_rows'];
        $config['per_page'] = $this->count_per_page;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);

        $this->load->view("template_paneladmin_view", $this->_data);
    }

}

?>