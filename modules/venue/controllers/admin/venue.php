<?php

class Venue extends Admin_Controller
{
	protected $uploadPath = 'uploads/venue';
protected $uploadthumbpath= 'uploads/venue/thumb/';

	public function __construct(){
    	parent::__construct();
        $this->load->module_model('venue','venue_model');
        $this->lang->module_load('venue','venue');
        //$this->bep_assets->load_asset('jquery.upload'); // uncomment if image ajax upload
    }
    
	public function index()
	{
		// Display Page
		$data['header'] = 'venue';
		$data['page'] = $this->config->item('template_admin') . "venue/index";
		$data['module'] = 'venue';
		$this->load->view($this->_container,$data);		
	}

	public function json()
	{
		$this->_get_search_param();	
		$total=$this->venue_model->count();
		paging('venue_id');
		$this->_get_search_param();	
		$rows=$this->venue_model->getVenues()->result_array();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
	}
	
	public function _get_search_param()
	{
		// Search Param Goes Here
		parse_str($this->input->post('data'),$params);
		if(!empty($params['search']))
		{
			($params['search']['venue_name']!='')?$this->db->like('venue_name',$params['search']['venue_name']):'';
			($params['search']['address']!='')?$this->db->like('address',$params['search']['address']):'';
			($params['search']['city']!='')?$this->db->like('city',$params['search']['city']):'';
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
		$rows=$this->venue_model->getVenues()->result_array();
		echo json_encode($rows);    	
    }    
    
	public function delete_json()
	{
    	$id=$this->input->post('id');
		if($id && is_array($id))
		{
        	foreach($id as $row):
				$this->venue_model->delete('VENUES',array('venue_id'=>$row));
            endforeach;
		}
	}    

	public function save()
	{
		
        $data=$this->_get_posted_data(); //Retrive Posted Data		

        if(!$this->input->post('venue_id'))
        {
			$data['added_date'] = date('Y-m-d H:i:s');
            $success=$this->venue_model->insert('VENUES',$data);
        }
        else
        {
			$data['modified_date'] = date('Y-m-d H:i:s');
            $success=$this->venue_model->update('VENUES',$data,array('venue_id'=>$data['venue_id']));
        }
        
		if($success)
		{
			$success = TRUE;
			$msg=lang('success_message'); 
		} 
		else
		{
			$success = FALSE;
			$msg=lang('failure_message');
		}
		 
		 echo json_encode(array('msg'=>$msg,'success'=>$success));		
        
	}
   
   private function _get_posted_data()
   {
   		$data=array();
        $data['venue_id'] = $this->input->post('venue_id');
		$data['venue_name'] = $this->input->post('venue_name');
		$data['description'] = $this->input->post('description');
		$data['address'] = $this->input->post('address');
		$data['city'] = $this->input->post('city');
		$data['longitude'] = $this->input->post('longitude');
		$data['latitude'] = $this->input->post('latitude');
		$data['venue_image'] = $this->input->post('venue_image');
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