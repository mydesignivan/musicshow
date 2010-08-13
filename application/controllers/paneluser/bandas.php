<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Bandas extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('bandas_model');
        $this->load->model('lists_model');
        $this->load->helper('form');

        $this->load->library('dataview', array(
            'tlp_section'  => 'paneluser/bandas_list_view.php',
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

        $listBandas = $this->bandas_model->get_list($this->_count_per_page, $offset);

        $config['base_url'] = site_url('/paneluser/bandas/index/page');
        $config['total_rows'] = $listBandas['count_rows'];
        $config['per_page'] = $this->_count_per_page;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);

        $this->_data = $this->dataview->set_data(array(
            'tlp_script'  => 'bandas_list',
            'listBandas'  => $listBandas['result']
        ));
        $this->load->view("template_paneluser_view", $this->_data);
    }

    public function form(){
        $id = $this->uri->segment(4);
        if( is_numeric($id) ){ //Edit
            $info = $this->bandas_model->get_info($id);
            $title = "Editar Banda";

        }else{     //New
            $info = false;
            $title = "Nueva Banda";
        }
        
        $this->_data = $this->dataview->set_data(array(
            'tlp_script'   => array('plugins_validator', 'popup', 'fancybox', 'jtable', 'json', 'bandas_form'),
            'tlp_section'  => 'paneluser/bandas_form_view.php',
            'info'         => $info,
            'title'        => $title,
            'comboStates'  => $this->lists_model->get_states(array(""=>"Seleccione una Provincia"), 13)
        ));
        $this->load->view("template_paneluser_view", $this->_data);
    }

    public function create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){

            //print_array($_POST, true);

            $resultUpload = $this->uploadimages->upload();
            
            if( $resultUpload['status']=="ok" ){

                redirect('/paneluser/recitales/');
            }
        }
    }

    public function edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $resultUpload = $this->uploadimages->upload();

            if( $resultUpload['status']=="ok" ){
                redirect('/paneluser/recitales/');
            }
        }
    }
    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            if( $this->recitales_model->delete(array('recital_id'=>$id)) ){
                redirect('/paneluser/recitales/');
            }else{
                show_error(ERR_RECITAL_DELETE);
            }
        }
    }

    /* FUNCTIONS AJAX
     **************************************************************************/
    public function ajax_check(){
        echo $this->recitales_model->check($_POST['banda'], $_POST['recitalid']);
        die();
    }

    public function ajax_show_states(){
        $comboCity = $this->lists_model->get_city($_POST['id']);
        echo '<option value="">Seleccione una Ciudad</option>\n';
        foreach( $comboCity as $row ){
            echo '<option value="'.$row['city_id'].'">'.$row['name'].'</option>\n';
        }
        die();
    }


    /* FUNCTIONS PRIVATE
     **************************************************************************/
    private function _request_fields(){
        $ret = array(
            'banda'         => $_POST['txtBanda'],
            'genero_id'     => $_POST['cboGenero'],
            'date'          => str_replace("/", ",", $_POST['txtDate']),
            'lugar_id'      => $_POST['lugar_id'],
            'lugarvta_id'   => @$_POST['lugarvta_id'],
            'price'         => $_POST['txtPrice'],
            'price2'        => $_POST['txtPrice2'],
            'moreinfo'      => $_POST['txtMoreInfo']
        );

        if( $_POST['cboTimerHour']!="null" && $_POST['cboTimerMinute']!="null" ){
            $ret['timer'] = $_POST['cboTimerHour'].":".$_POST['cboTimerMinute'];
        }

        return $ret;
    }

}

?>