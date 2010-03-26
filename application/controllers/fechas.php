<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Fechas extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Controller();
        $this->load->model('lists_model');
        $this->load->model('search_model');


       $prefs['template'] = '
           {table_open}<table class="table-calendar" border="0" cellpadding="0" cellspacing="0">{/table_open}
           {heading_row_start}<tr>{/heading_row_start}
           {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
           {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
           {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
           {heading_row_end}</tr>{/heading_row_end}
           {week_row_start}<tr>{/week_row_start}
           {week_day_cell}<td>{week_day}</td>{/week_day_cell}
           {week_row_end}</tr>{/week_row_end}

           {cal_row_start}<tr>{/cal_row_start}
           {cal_cell_start}<td>{/cal_cell_start}
           {cal_cell_content}<a href="{content}" class="mark">{day}</a>{/cal_cell_content}
           {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
           {cal_cell_no_content}{day}{/cal_cell_no_content}
           {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
           {cal_cell_blank}&nbsp;{/cal_cell_blank}
           {cal_cell_end}</td>{/cal_cell_end}
           {cal_row_end}</tr>{/cal_row_end}
           {table_close}</table>{/table_close}';
        $this->load->library('calendar', $prefs);


        $this->load->library('dataview', array(
            'listGeneros'  => $this->lists_model->get_generos(),
            'tlp_section' => 'frontpage/dates_view.php',
            'tlp_script'  => 'dates',
            'tlp_title'   => TITLE_FECHAS
        ));
        $this->_data = $this->dataview->get_data();
    }

    /* PRIVATE PROPERTIES
     **************************************************************************/
    private $_data;

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        $where = $orderby = array();
        $where['date'] = "str_to_date(`date`, '%d,%m,%Y') >= str_to_date('".date('d,m,Y')."', '%d,%m,%Y') and str_to_date(`date`,'%d,%m,%Y') <= str_to_date('31,12,2010', '%d,%m,%Y')";
        $orderby = "CAST(str_to_date(`date`, '%d,%m,%Y') as datetime)";

        $listResult = $this->search_model->search($where, $orderby);

        $row = $listResult['result']->row_array();

        $where['date'] = "`date`='".$row['date']."'";
        $listResultSearch = $this->search_model->search($where);

        $this->_data = $this->dataview->set_data(array(
            'listResult' => $listResult['result'],
            'listResultSearch' => $listResultSearch['result']
        ));

        $this->load->view('template_frontpage_view', $this->_data);
    }
    
    /* FUNCTIONS AJAX
     **************************************************************************/
    public function ajax_show_result(){
        $where['date'] = "`date`='".$_POST['date']."'";
        $listResultSearch = $this->search_model->search($where);
        $this->load->view('ajax_view', array(
            'section'          =>  'frontpage/ajax/search_list_view.php',
            'listResultSearch' => $listResultSearch['result']
        ));
    }

}
?>
