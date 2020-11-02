<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thankyou extends CI_Controller {

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
	}

	public function index()
	{
		$header['page_title']="Thank You";
		$header['page_description']="Thank You";
		$header['count']=0;
		if(!empty(get_cookie('orderid'))) {
			$where_condition=array("order_id"=>get_cookie('orderid'));
			$get_status=json_decode($this->Data_model->get_all_data("*","order",$where_condition),true);
			if($get_status['status']==1)
				{
					$data['order']=$get_status['result'];
				}
				else
				{
					$data['order']=array();
				}
				$this->load->view('header',$header);
				$this->load->view('checkout/thank-you',$data);
				$this->load->view('footer');
		}
		else { 
			$this->load->view('header',$header);
			$this->load->view('404');
			$this->load->view('footer');
		}
	}
}	
