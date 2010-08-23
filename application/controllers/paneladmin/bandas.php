<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Bandas extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==0 ) redirect('/index/');
        
        $this->load->model('bandas_model');
        $this->load->model('lists_model');
        $this->load->helper('form');

        $this->load->library('dataview', array(
            'tlp_section'  => 'paneladmin/bandas_list_view.php',
            'tlp_title'    => 'Bandas'
        ));
        $this->_data = $this->dataview->get_data();

        $this->_count_per_page=10;
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;
    private $_count_per_page;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->load->library('pagination');

        $uri = $this->uri->uri_to_assoc(2);
        $offset = !isset($uri['page']) ? 0 : $uri['page'];

        $listBandas = $this->bandas_model->get_list($this->_count_per_page, $offset, array());

        $config['base_url'] = site_url('/paneladmin/bandas/index/page');
        $config['total_rows'] = $listBandas['count_rows'];
        $config['per_page'] = $this->_count_per_page;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);

        $this->_data = $this->dataview->set_data(array(
            'tlp_script'  => 'bandas_list',
            'listBandas'  => $listBandas['result']
        ));
        $this->load->view("template_paneladmin_view", $this->_data);
    }

    public function show(){
        $id = $this->uri->segment(4);
        if( is_numeric($id) ){ //Edit

            $info = $this->bandas_model->get_info($id);

            //print_array($info, true);

            $info['state'] = $this->lists_model->get_value(TBL_STATES, array('state_id' => $info['state_id']));
            $info['city'] = $this->lists_model->get_value(TBL_CITY, array('city_id' => $info['city_id']));

            $this->_data = $this->dataview->set_data(array(
                'tlp_script'   => array('fancybox'),
                'tlp_section'  => 'paneladmin/bandas_form_view.php',
                'info'         => $info
            ));
            $this->load->view("template_paneladmin_view", $this->_data);
        }
    }

    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            //print_array($id, true);

            if( !$this->bandas_model->delete($id) ){
                $this->session->set_flashdata('status', "error");
                $this->session->set_flashdata('message', ERR_DB);
            }else{
                $this->session->set_flashdata('status', "success");
                $this->session->set_flashdata('message', "La eliminaci&oacute;n ha sido realizada con &eacute;xito.");
            }
            redirect('/paneladmin/bandas/');
        }
    }

    /* FUNCTIONS AJAX
     **************************************************************************/


    /* FUNCTIONS PRIVATE
     **************************************************************************/

}