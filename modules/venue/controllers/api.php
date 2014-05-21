<?php

class {CONTROLLER} extends API_Controller
{
	
	public function __construct(){
    	parent::__construct();
        $this->load->module_model('venue','venue_model');
        $this->lang->module_load('venue','{LANG}');
    }
    	    
}