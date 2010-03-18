<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dataview{

    private $CI;
    private $_data;
    function  __construct() {
        $this->CI =& get_instance();
    }

    public function initializer($type){
        switch($type){
            case "frontpage": default:
                $this->CI->load->model('lists_model');
                $this->_data = array(
                    'listGeneros'  => $this->CI->lists_model->get_generos()
                );
            break;
            case "paneluser":
            break;
            case "paneladmin":
            break;
        }
    }

    public function data($key=null){
        if( $key!=null ) 
            return $this->_data[$key];
        else 
            return $this->_data;
    }

    public function set_data($param1, $param2=null){
        if( is_string($param1) && is_string($param1) )
            $param1 = array($param1=>$param2);
        
        foreach( $param1 as $key=>$val ){
            if( array_key_exists($key, $this->_data) ){
                $this->_data[$key] = $param1[$key];
            }else{
                $this->_data[$key] = $param1[$key];
            }
        }
        return $this->_data;
    }


}
?>
