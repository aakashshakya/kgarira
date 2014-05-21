<?php

class Event extends Admin_Controller
{
	protected $uploadPath = 'uploads/event';
protected $uploadthumbpath= 'uploads/event/thumb/';

	public function __construct(){
    	parent::__construct();
        $this->load->module_model('event','event_model');
        $this->lang->module_load('event','event');
        //$this->bep_assets->load_asset('jquery.upload'); // uncomment if image ajax upload
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'event';
		$data['page'] = $this->config->item('template_admin') . "event/index";
		$data['module'] = 'event';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$this->event_model->joins=array('VENUES');
		$total=$this->event_model->count();
		paging('event_id');
		$this->_get_search_param();	
		$rows=$this->event_model->getEvents()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		// Search Param Goes Here
		parse_str($this->input->post('data'),$params);
		if(!empty($params['search']))
		{
			($params['search']['event_title']!='')?$this->db->like('event_title',$params['search']['event_title']):'';
($params['search']['venue_id']!='')?$this->db->where('venue_id',$params['search']['venue_id']):'';
($params['search']['user_id']!='')?$this->db->where('user_id',$params['search']['user_id']):'';
(isset($params['search']['status']))?$this->db->where('status',$params['search']['status']):'';

		}  

		
		if(!empty($params['date']))
		{
			foreach($params['date'] as $key=>$value){
				$this->_datewise($key,$value['from'],$value['to']);	
			}
		}
		               
        
	}

	
	private function _datewise($field,$from,$to)
	{
			if(!empty($from) && !empty($to))
			{
				$this->db->where("(date_format(".$field.",'%Y-%m-%d') between '".date('Y-m-d',strtotime($from)).
						"' and '".date('Y-m-d',strtotime($to))."')");
			}
			else if(!empty($from))
			{
				$this->db->like($field,date('Y-m-d',strtotime($from)));				
			}		
	}	
    
	public function combo_json()
    {
		$rows=$this->event_model->getEvents()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->event_model->delete('EVENTS',array('event_id'=>$row));
            endforeach;
		}
	}    

	public function save()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('event_id'))
        {
			$data['added_date'] = date('Y-m-d H:i:s');
            $success=$this->event_model->insert('EVENTS',$data);
        }
        else
        {
            $success=$this->event_model->update('EVENTS',$data,array('event_id'=>$data['event_id']));
        }
        
		if($success)
		{
			$success = TRUE;
			$msg=lang('success_message'); 
		} 
		else
		{
			$success = FALSE;
			$msg=lang('failure_m
			essage');
		}
		 
		 echo json_encode(array('msg'=>$msg,'success'=>$success));		
        
	}
   
   private function _get_posted_data()
   {
   		$data=array();
        $data['event_id'] = $this->input->post('event_id');
$data['event_title'] = $this->input->post('event_title');
$data['description'] = $this->input->post('description');
$data['event_image'] = $this->input->post('event_image');
$data['venue_id'] = $this->input->post('venue_id');
$data['user_id'] = $this->input->post('user_id');
$data['start_date'] = $this->input->post('start_date');
$data['end_date'] = $this->input->post('end_date');
$data['status'] = $this->input->post('status');

        return $data;
   }
   
      function upload_image(){
		//Image Upload Config
		$config['upload_path'] = $this->uploadPath;
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size']	= '10240';
		$config['remove_spaces']  = true;
		//load upload library
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors('','');
			echo json_encode($data);
		}
		else
		{
		  $data = $this->upload->data();
 		  $config['image_library'] = 'gd2';
		  $config['source_image'] = $data['full_path'];
          $config['new_image']    = $this->uploadthumbpath;
		  //$config['create_thumb'] = TRUE;
		  $config['maintain_ratio'] = TRUE;
		  $config['height'] =100;
		  $config['width'] = 100;

		  $this->load->library('image_lib', $config);
		  $this->image_lib->resize();
		  echo json_encode($data);
	    }
	}
	
	function upload_delete(){
		//get filename
		$filename = $this->input->post('filename');
		@unlink($this->uploadPath . '/' . $filename);
	} 	
	    
}