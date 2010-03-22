<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==0 ) redirect('/index/');
        
        $this->load->model('recitales_model');
        $this->load->library('dataview');
        $this->load->library('pagination');

        $this->dataview->initializer('paneladmin');
        $this->_data = $this->dataview->set_data(array(
            'tlp_section'  => 'paneladmin/recitales_list_view.php',
            'tlp_title'    => 'Recitales'
        ));
        $this->count_per_page=3;
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;
    private $count_per_page;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $offset = !is_numeric($this->uri->segment(4)) ? 0 : $this->uri->segment(4);
        $listRecitales = $this->recitales_model->get_list_paginator($this->count_per_page, $offset);

        $this->_data = $this->dataview->set_data(array(
            'tlp_script'    => 'recitales_list',
            'listRecitales' =>  $listRecitales['result']
        ));

        $config['base_url'] = str_replace(".html", "", site_url('/paneladmin/recitales/index/'));
        $config['total_rows'] = $listRecitales['count_rows'];
        $config['per_page'] = $this->count_per_page;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);

        $this->load->view("template_paneladmin_view", $this->_data);
    }

    public function view(){
        $info = $this->recitales_model->get_view_recital($this->uri->segment(4));

        $this->_data = $this->dataview->set_data(array(
            'tlp_section'   => 'paneladmin/recitales_view_view.php',
            'tlp_title'     => 'Recitales Detalle',
            'listRecitales' => null,
            'info'          => $info
        ));
        $this->load->view("template_paneladmin_view", $this->_data);
    }

    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            if( $this->recitales_model->delete($id) ){
                redirect('/paneladmin/recitales/');
            }else{
                show_error(ERR_RECITAL_DELETE);
            }
        }
    }


    /* PRIVATE FUNCTIONS
     **************************************************************************/
}

?>