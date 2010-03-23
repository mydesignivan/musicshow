<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Recitales extends Controller{

    private $_data;
    function __construct(){
        parent::Controller();
        if( !$this->session->userdata('logged_in') || $this->session->userdata('level')==1 ) redirect('/index/');
        
        $this->load->model('recitales_model');
        $this->load->model('lists_model');
        $this->load->helper('form');
        $this->load->library('dataview');

        $this->dataview->initializer('paneluser');
        $this->_data = $this->dataview->set_data(array(
            'tlp_section'  => 'paneluser/recitales_list_view.php',
            'tlp_title'    => 'Recitales'
        ));
    }

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
            'tlp_script'   => array('validator', 'popup', 'recitales_form'),
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
                $data = array_merge(array(
                    'image1_full'    => $resultUpload['image_full'][0],
                    'image2_full'    => $resultUpload['image_full'][1],
                    'image3_full'    => $resultUpload['image_full'][2],
                    'image4_full'    => $resultUpload['image_full'][3],
                    'image5_full'    => $resultUpload['image_full'][4],
                    'image1_thumb'   => $resultUpload['image_thumb'][0],
                    'image2_thumb'   => $resultUpload['image_thumb'][1],
                    'image3_thumb'   => $resultUpload['image_thumb'][2],
                    'image4_thumb'   => $resultUpload['image_thumb'][3],
                    'image5_thumb'   => $resultUpload['image_thumb'][4],
                    'user_id'       => $this->session->userdata('user_id'),
                    'date_added'    => date('Y-m-d h:i:s')
                ), $data);
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
                $data = array_merge(array(
                    'image1_full'    => $resultUpload['image_full'][0],
                    'image2_full'    => $resultUpload['image_full'][1],
                    'image3_full'    => $resultUpload['image_full'][2],
                    'image4_full'    => $resultUpload['image_full'][3],
                    'image5_full'    => $resultUpload['image_full'][4],
                    'image1_thumb'   => $resultUpload['image_thumb'][0],
                    'image2_thumb'   => $resultUpload['image_thumb'][1],
                    'image3_thumb'   => $resultUpload['image_thumb'][2],
                    'image4_thumb'   => $resultUpload['image_thumb'][3],
                    'image5_thumb'   => $resultUpload['image_thumb'][4],
                    'last_modified'   =>  date('Y-m-d h:i:s'),
                    'json'            =>  $_POST['json']
                ), $data);

                $this->recitales_model->edit($data, $_POST['recital_id']);
                redirect('/paneluser/recitales/');
            }
        }
    }
    public function delete(){
        if( $this->uri->segment(4) ){
            $id = $this->uri->segment_array();
            array_splice($id, 0,3);

            if( $this->recitales_model->delete($id) ){
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

        /*echo "<pre>";
        print_r($_FILES);
        echo "</pre>";*/

        $files = array();
        $files['name'] = $_FILES['fileUpload']['name'];
        $files['tmp_name'] = $_FILES['fileUpload']['tmp_name'];
        $files['type'] = $_FILES['fileUpload']['type'];
        $return = array();

        for( $n=0; $n<=4; $n++ ) {
            $return['image_full'][$n]='';
            $return['image_thumb'][$n]='';
        }

        for( $n=0; $n<=count($files['name'])-1; $n++ ){
            $name = $files['name'][$n];
            if( $name!='' ){
                $partfile = part_filename(strtolower($name));
                $filename = $this->session->userdata('user_id') ."_". uniqid(time()) .".".$partfile['ext'];

                // Muevo la imagen original
                move_uploaded_file($files['tmp_name'][$n], UPLOAD_DIR.$filename);

                // Creo una copia y dimensiono la imagen  (THUMB)
                $config['image_library'] = 'GD2';
                $config['source_image'] = UPLOAD_DIR.$filename;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = IMAGE_THUMB_WIDTH;
                $config['height'] = IMAGE_THUMB_HEIGHT;
                $this->image_lib->initialize($config);
                if( !$this->image_lib->resize() ) die($this->image_lib->display_errors());

                // Dimensiono la imagen original   (ORIGINAL)
                $config['image_library'] = 'GD2';
                $config['source_image'] = UPLOAD_DIR.$filename;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = IMAGE_ORIGINAL_WIDTH;
                $config['height'] = IMAGE_ORIGINAL_HEIGHT;
                $this->image_lib->initialize($config);
                if( !$this->image_lib->resize() ) die($this->image_lib->display_errors());

                $partfile = part_filename($filename);
                $return['image_full'][$n] = $filename;
                $return['image_thumb'][$n] = $partfile['basename']."_thumb.".$partfile['ext'];
            }
        }

        $return['status']="ok";
        return $return;
    }

}

?>