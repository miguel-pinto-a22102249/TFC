<?

class Error404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $CI = &get_instance();
        $CI->output->set_status_header('404');
        $this->load->view('base/page_not_found');
    }

}
