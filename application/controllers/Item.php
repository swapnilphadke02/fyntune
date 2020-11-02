<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent:: __construct();	
		if(empty($this->session->userdata('logged_in')))
		{
			redirect(base_url());
		}
	}


	public function index()
	{
		$this->load->library("pagination");
		$header['page_title']="Products";
		$header['page_description']="Products Of First Venture";
		$header['page_heading']="Products";
		$config = array();
        $config["base_url"] = base_url() . "/item/index";
        $config["total_rows"] = $this->Data_model->get_row_count("products");
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
        $data['products'] = json_decode($this->Data_model->get_all_data("*","products","","","","",$page,$config["per_page"]),true);
		$this->load->view('header',$header);
		$this->load->view('product/view',$data);
		$this->load->view('footer');
	}

	public function add()
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('product_price', 'Product Price', 'numeric|trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('product_weight', 'Product Weight', 'numeric|trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('short_description', 'Short Description', 'trim|max_length[255]|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('product_quantity', 'Product Quantity', 'numeric|trim|required|xss_clean|strip_tags');
			if($this->form_validation->run() !== false) 
			{
				$product_name=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_name']))));
				$product_price=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_price']))));
				$product_weight=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_weight']))));
				$short_description=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['short_description']))));
				$product_quantity=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_quantity']))));
				$insert_data=array("product_name"=>$product_name,"product_price"=>$product_price,"product_weight"=>$product_weight,"short_description"=>$short_description,"product_quantity"=>$product_quantity);
				$get_insert=json_decode($this->Data_model->insert_data($insert_data,"products"),true);
				if($get_insert['status']==1)
				{
					$this->session->set_flashdata('flashsuccess', "Product added successfully");
					redirect(base_url('item/add'));exit;
				}
				else
				{
					$this->session->set_flashdata('flasherror', "Unable to add product. Contact Admin.");
					redirect(base_url('item/add'));exit;
				}

			}
			else
			{
				$errors = array();
				$string="";
				$errors = $this->form_validation->error_array();
				foreach($errors as $key=>$value){	$string .= $value.'<br/>'; }
				$finresult =  array( 'status'=>'failed', 'message'=> $string );
				$template['error']=json_encode($finresult);
				$this->session->set_flashdata('flasherror', $string);
				redirect(base_url('item/add'));exit;	
			}
		}
		else
		{
			$header['page_title']="Products";
			$header['page_description']="Products Of First Venture";
			$header['page_heading']="Products";	
			$this->load->view('header',$header);
			$this->load->view('product/add');
			$this->load->view('footer');
		}
	}

	public function edit($id)
	{
		if($id !="")
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('product_price', 'Product Price', 'numeric|trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('product_weight', 'Product Weight', 'numeric|trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('short_description', 'Short Description', 'trim|max_length[255]|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('product_quantity', 'Product Quantity', 'numeric|trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('product_id', 'Product Id', 'numeric|trim|required|xss_clean|strip_tags');
				if($this->form_validation->run() !== false) 
				{
					$product_id=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_id']))));
					$product_name=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_name']))));
					$product_price=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_price']))));
					$product_weight=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_weight']))));
					$short_description=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['short_description']))));
					$product_quantity=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['product_quantity']))));
					$update_data=array("product_name"=>$product_name,"product_price"=>$product_price,"product_weight"=>$product_weight,"short_description"=>$short_description,"product_quantity"=>$product_quantity);
					//$decode_id=$this->decode($product_id);
					$update_condition=array("product_id"=>$product_id);
					$get_update=json_decode($this->Data_model->update_data('products',$update_condition,$update_data),true);
					if($get_update['status']==1)
					{
						$this->session->set_flashdata('flashsuccess', "Product Updated successfully");
						redirect(base_url('item/edit/'.$product_id));exit;
					}
					else
					{
						$this->session->set_flashdata('flasherror', "Unable to update product. Contact Admin.");
						redirect(base_url('item/edit/'.$product_id));exit;
					}

				}
				else
				{
					$errors = array();
					$string="";
					$errors = $this->form_validation->error_array();
					foreach($errors as $key=>$value){	$string .= $value.'<br/>'; }
					$finresult =  array( 'status'=>'failed', 'message'=> $string );
					$template['error']=json_encode($finresult);
					$this->session->set_flashdata('flasherror', $string);
					redirect(base_url('item/add'));exit;	
				}
			}
			else
			{
				$header['page_title']="Products";
				$header['page_description']="Products Of First Venture";
				$header['page_heading']="Products";
				$where_condition=array("product_id"=>$id);
				$get_status=json_decode($this->Data_model->get_all_data("*","products",$where_condition),true);
				if($get_status['status']==1)
				{
				$data['product']=$get_status['result'];	
				$this->load->view('header',$header);
				$this->load->view('product/edit',$data);
				$this->load->view('footer');
				}
				else
				{
					$this->load->view('404');
				}
			}
		}
		else
		{
			$this->load->view('404');
		}
	}

	public function delete($id)
	{
		$where_condition=array(product_id=>$id);
		$get_status=json_decode($this->Data_model->get_all_data("product_id","products",$where_condition),true);
				if($get_status['status']==1)
				{
					if($this->Data_model->delete_data("products",$where_condition))
					{
						$this->session->set_flashdata('flashsuccess', "Product Deleted");
						redirect(base_url('item'));exit;	
					}
					else
					{
						$this->session->set_flashdata('flasherror', "Error Occured. Contact Admin");
						redirect(base_url('item'));exit;
					}	

				}
				else
				{
					$this->load->view('404');
				}
	}

}
