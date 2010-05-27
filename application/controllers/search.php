<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Search extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Controller();
        $this->load->model('search_model');
        $this->load->model('lists_model');
        $this->load->library('pagination');
        $this->load->library('dataview', array(
            'listGeneros'  => $this->lists_model->get_generos(),
            'tlp_section' => 'frontpage/resultsearch_view.php',
            'tlp_title'   => TITLE_INDEX
        ));
        $this->_data = $this->dataview->get_data();

        $this->count_per_page = 10;
    }
	
    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;
    private $count_per_page;

    /* PUBLIC FUNCTION
     **************************************************************************/
    public function index(){
        $arr_seg = $this->uri->uri_to_assoc(3, array('genero', 'keyword', 'date', 'page'));
        $offset = empty($arr_seg['page']) ? 0 : $arr_seg['page'];

        $base_url = site_url('/search/index/');
        $order_by = "CAST(str_to_date(`date`, '%d,%m,%Y') AS datetime) asc";
        $listResultSearch = $this->search_model->search($arr_seg, $order_by, $this->count_per_page, $offset);

        $config['base_url'] = $this->_get_basename();
        $config['total_rows'] = $listResultSearch['count_rows'];
        $config['per_page'] = $this->count_per_page;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);

        $this->_data = $this->dataview->set_data(array(
            'listResultSearch' => $listResultSearch['result']
        ));

        $this->load->view('template_frontpage_view', $this->_data);
    }

    /* PRIVATE FUNCTION
     **************************************************************************/
    private function _get_basename(){
        $arr = $this->uri->segment_array();
        
        if( $arr[count($arr)-1]=="page" ){
            $str = implode("/", array_splice($arr, 0, count($arr)-1));
        }elseif( $arr[count($arr)]=="page" ){
            $str = implode("/", array_splice($arr, 0, count($arr)));
        }else{
            $str = implode("/", $arr)."/page";
        }

        return site_url($str);
    }

}
?>
