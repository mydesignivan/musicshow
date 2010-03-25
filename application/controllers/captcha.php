<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Captcha extends Controller {

    /* CONSTRUCTOR
     **************************************************************************/
    function __construct(){
        parent::Controller();
        $this->load->library('captcha/securimage');
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function index(){
        // Change some settings

        $this->securimage->image_width = 230;
        $this->securimage->image_height = 80;

        $this->securimage->ttf_file = 'ITCKrist.TTF';
        $this->securimage->perturbation = 0.5;
        $this->securimage->image_bg_color = new Securimage_Color(0xff, 0xff, 0xff);
        $this->securimage->text_color = new Securimage_Color(0x70, 0x70, 0x70);
        $this->securimage->use_transparent_text = false;
        $this->securimage->num_lines = 10;
        $this->securimage->line_color = new Securimage_Color(0x70, 0x70, 0x70);
        $this->securimage->draw_lines_over_text = true;

        $this->securimage->show();
    }

    public function play(){
        $this->securimage->audio_format = (isset($_GET['format']) && in_array(strtolower($_GET['format']), array('mp3', 'wav')) ? strtolower($_GET['format']) : 'mp3');
        //$img->setAudioPath('/path/to/securimage/audio/');

        $this->securimage->outputAudioFile();
    }

}

?>