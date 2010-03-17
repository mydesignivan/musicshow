<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dataview{

    private $CI;
    private $_data;
    function  __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('lists_model');
        $this->_data = array(
            'listGeneros'  => $this->CI->lists_model->get_generos()
        );
    }

    public function data($key=null){
        if( $key!=null ) 
            return $this->_data[$key];
        else 
            return $this->_data;
    }

    public function set_data($param1, $param2=null){
        if( is_string($param1) && is_string($param1) ){
            $param1 = array($param1=>$param2);
        }

        return $this->_data = array_merge($param1, $this->_data);
    }


}
?>
