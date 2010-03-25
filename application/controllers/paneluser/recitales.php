<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('recitales_model');
        $this->load->model('lists_model');
        $this->load->helper('form');
        $this->load->library('dataview', array(
            'tlp_section'  => 'paneluser/recitales_list_view.php',
            'tlp_title'    => 'Recitales'
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $this->_data = $this->dataview->set_data(array(
            'tlp_script'    => 'recitales_list',
            'listRecitales' =>  $this->recitales_model->get_list()
        ));
        $this->load->view("template_paneluser_view", $this->_data);
    }
    public function form(){
        $info = false;
        $message = "";
        $show_form = true;
        if( is_numeric($this->uri->segment(4)) ) $info = $this->recitales_model->get_recital($this->uri->segment(4));
        else{
            $count = $this->recitales_model->get_count_recitales();
            if( $count>=CFG_COUNT_FREE_RECITAL ){
                $show_form = false;
                $message = 'Estimado usuario, le informamos que el servicio gratuito que usted dispone, le permite cargar un maximo de ('.CFG_COUNT_FREE_RECITAL.') recitales.';
            }
        }

        $this->_data = $this->dataview->set_data(array(
            'tlp_script'   => array('validator', 'popup', 'fancybox', 'recitales_form'),
            'tlp_section'  => 'paneluser/recitales_form_view.php',
            'comboGeneros' =>  $this->lists_model->get_generos(array("0"=>"Seleccione un Genero")),
            'info'         =>  $info,
            'show_form'    =>  $show_form,
            'message'      =>  $message
        ));

        $this->load->view("template_paneluser_view", $this->_data);
    }

    public function create(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $resultUpload = $this->_upload();
            if( $resultUpload['status']=="ok" ){
                // Guardo los datos
                $data = $this->_request_fields();
                $data['user_id'] = $this->session->userdata('user_id');
                $data['date_added'] = date('Y-m-d h:i:s');
                $data = array_merge($resultUpload['result'], $data);

                $this->recitales_model->create($data);

                redirect('/paneluser/recitales/');
            }
        }
    }

    public function edit(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            $resultUpload = $this->_upload();

            if( $resultUpload['status']=="ok" ){
                $data = $this->_request_fields();
                $data['last_modified'] = date('Y-m-d h:i:s');
                $data['json'] = $_POST['json'];
                $data = array_merge($resultUpload['result'], $data);

                $this->recitales_model->edit($data, $_POST['recital_id']);
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
    public function ajax_show_city(){
        $comboCity = $this->lists_model->get_city($this->uri->segment(4));
        echo '<option value="0">Seleccione una Ciudad</option>\n';
        foreach( $comboCity as $row ){
            echo '<option value="'.$row['city_id'].'">'.$row['name'].'</option>\n';
        }
        die();
    }
    public function ajax_load_lugar(){
        $this->load->view('ajax_view', array(
            'section'      =>  'paneluser/ajax/popup_lugar_view.php',
            'comboStates'  =>  $this->lists_model->get_states(array("0"=>"Seleccione una Provincia"), 13)
        ));
    }
    public function ajax_list_lugar(){
        $this->load->view('ajax_view', array(
            'section'      =>  'paneluser/ajax/table_lugares_view.php',
            'listLugares'  =>  $this->recitales_model->list_lugares($this->uri->segment(4))
        ));
    }
    public function ajax_save_lugar(){
        if( $_SERVER['REQUEST_METHOD']=="POST" ){
            if( $this->recitales_model->save_lugares() )
                die("ok");
        }
    }
    public function ajax_del_lugar(){
        if( $this->uri->segment(4) ){
            $result = $this->recitales_model->delete_lugar($this->uri->segment(4));
            echo json_encode($result);
        }
    }

    /* FUNCTIONS PRIVATE
     **************************************************************************/
    private function _request_fields(){
        return array(
            'banda'         => $_POST['txtBanda'],
            'genero_id'     => $_POST['cboGenero'],
            'date'          => $_POST['txtDate'],
            'lugar_id'      => $_POST['lugar_id'],
            'lugarvta_id'   => $_POST['lugarvta_id'],
            'price'         => $_POST['txtPrice'],
            'price2'        => $_POST['txtPrice2']
        );
    }

    private function _upload(){
        $this->load->library('image_lib');

        $return = array(
            'status'=>"ok",
            'result'=>array()
        );
        $files = array();
        $files['name'] = $_FILES['fileUpload']['name'];
        $files['tmp_name'] = $_FILES['fileUpload']['tmp_name'];
        $files['type'] = $_FILES['fileUpload']['type'];
        $user_id = $this->session->userdata('user_id');

        for( $n=0; $n<=count($files['name'])-1; $n++ ){
            $name = $files['name'][$n];
            if( $name!='' ){
                $partfile = part_filename(strtolower($name));
                $filename = $user_id ."_". uniqid(time()) .".".$partfile['ext'];

                // Muevo la imagen original
                move_uploaded_file($files['tmp_name'][$n], UPLOAD_DIR.$filename);

                // Creo una copia y dimensiono la imagen  (THUMB)
                $this->image_lib->clear();
                $config['image_library'] = 'GD2';
                $config['source_image'] = UPLOAD_DIR.$filename;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = IMAGE_THUMB_WIDTH;
                $config['height'] = IMAGE_THUMB_HEIGHT;
                $this->image_lib->initialize($config);
                if( !$this->image_lib->resize() ) die($this->image_lib->display_errors());

                $partfile = part_filename($filename);
                $return['result']['image'.($n+1).'_full'] = $filename;
                $return['result']['image'.($n+1).'_thumb'] = $partfile['basename']."_thumb.".$partfile['ext'];
            }
        }
        return $return;
    }

}

?>