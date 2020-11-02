<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry extends CI_Controller {

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
		if(!empty($this->session->userdata('logged_in')))
		{
			redirect(base_url());
		}
	}

	public function index()
	{
		$header['page_title']="Login/ Register";
		$header['page_description']="Login/ Register to First Venture";
		$header['page_heading']="Login / Register to First Venture";	
		$this->load->view('header',$header);
		$this->load->view('login');
		$this->load->view('footer');
	}

	public function login()
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->form_validation->set_rules('login_email', 'Email Address', 'valid_email|trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('login_password', 'Password', 'min_length[7]|max_length[10]|trim|required|xss_clean|strip_tags');
			if($this->form_validation->run() !== false) 
			{
				$email=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['login_email']))));
				$password=md5(trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['login_password'])))));
				$where_condition=array("email"=>$email,"status"=>"1");
				$get_status=json_decode($this->Data_model->get_all_data("customer_id,email,password","customer",$where_condition),true);
				if($get_status['status']==1 && $password==$get_status['result'][0]['password'])
				{
					$this->session->set_userdata("logged_in",$get_status['result'][0]['customer_id']);
					redirect(base_url('checkout'));exit;
				}
				else
				{
					$this->session->set_flashdata('flasherror', "Unknown Credentials");
					redirect(base_url('checkout'));exit;
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
				redirect(base_url('checkout'));exit;	
			}
		}
		else
		{
		$this->load->view('404');
		}
	}

	public function my_404()
	{
		$this->load->view('404');
	}
}
