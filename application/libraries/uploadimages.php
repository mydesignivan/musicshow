<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uploadimages{

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct($param) {
        $this->CI =& get_instance();
        $this->CI->load->library('image_lib');

        $this->filename = $param['filename'];
        $this->upload_dir = $param['upload_dir'];
        if( isset($param['upload_maxsize']) ) $this->upload_maxsize = $param['upload_maxsize'];
        if( isset($param['upload_filetype']) ) $this->upload_filetype = $param['upload_filetype'];
        $this->image_thumb_width = $param['image_thumb_width'];
        $this->image_thumb_height = $param['image_thumb_height'];
        $this->active_valid = !isset($param['active_valid']) ? true : $param['active_valid'];
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $CI;
    private $filename;
    private $upload_dir;
    private $upload_maxsize;
    private $upload_filetype;
    private $image_thumb_width;
    private $image_thumb_height;
    private $active_valid;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function upload(){
        $return = array(
            'status'=>"ok",
            'result'=>array()
        );
        $files = array();
        $files['name'] = $_FILES[$this->filename]['name'];
        $files['tmp_name'] = $_FILES[$this->filename]['tmp_name'];
        $files['type'] = $_FILES[$this->filename]['type'];
        $files['size'] = $_FILES[$this->filename]['size'];
        $user_id = $this->CI->session->userdata('user_id');

        for( $n=0; $n<=count($files['name'])-1; $n++ ){
            $name = $files['name'][$n];
            if( $name!='' ){
                if( $this->active_valid ){
                    $resValid = $this->_validate($files['tmp_name'][$n], $files['size'][$n], $files['type'][$n]);
                }else $resValid="ok";

                if( $resValid=="ok" ){
                    $partfile = $this->_part_filename(strtolower($name));
                    $filename = $user_id ."_". uniqid(time()) .".".$partfile['ext'];

                    // Muevo la imagen original
                    move_uploaded_file($files['tmp_name'][$n], $this->upload_dir.$filename);

                    // Creo una copia y dimensiono la imagen  (THUMB)
                    $this->CI->image_lib->clear();
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->upload_dir.$filename;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = $this->image_thumb_width;
                    $config['height'] = $this->image_thumb_height;
                    $this->CI->image_lib->initialize($config);
                    if( !$this->CI->image_lib->resize() ) die($this->CI->image_lib->display_errors());

                    $partfile = $this->_part_filename($filename);
                    $return['result']['image'.($n+1).'_full'] = $filename;
                    $return['result']['image'.($n+1).'_thumb'] = $partfile['basename']."_thumb.".$partfile['ext'];
                }else{
                    $return['status'] = "error";
                    $return['error'][] = $resValid;
                    $return['error_file'] = $name;
                }
            }
        }
        
        return $return;
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _validate($tmp_name, $size, $type){
        if( !is_uploaded_file($tmp_name) ) return "ERR_UPLOAD_NOTUPLOAD";
        $size = (int)$this->upload_maxsize;
        if( round($size/1024, 2) > (int)$this->upload_maxsize ) return "ERR_UPLOAD_MAXSIZE";
        if( !$this->_is_allowed_filetype($type) ) return "ERR_UPLOAD_FILETYPE";

        return "ok";
    }
    private function _is_allowed_filetype($type){
        require_once(APPPATH.'config/mimes'.EXT);

        $extention = explode("|", $this->upload_filetype);
        foreach( $extention as $ext ){
            $mime = $mimes[$ext];

            if( is_array($mime) ){
                if( in_array($type, $mime) ) return true;
            }else{
                if( $mime==$type ) return true;
            }
        }
        return false;
    }
    private function _part_filename($name){
        return array(
            'ext'=>substr($name, (strripos($name, ".")-strlen($name))+1),
            'basename'=>substr($name, 0, strripos($name, "."))
        );
    }

}
?>
