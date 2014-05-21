{PHP_TAG}

class {CONTROLLER} extends API_Controller
{
	
	public function __construct(){
    	parent::__construct();
        $this->load->module_model('{MODULE}','{MODEL}');
        $this->lang->module_load('{MODULE}','{LANG}');
    }
    	    
}