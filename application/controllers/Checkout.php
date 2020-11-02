<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

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
		if(count($this->cart->contents()) < 1)
		{
			redirect(base_url());exit;
		}
	}

	public function index()
	{
		$header['page_title']="Checkout";
		$header['page_description']="Checkout Page";
		$header['count']=count($this->cart->contents());
		$data['cart'] = $this->cart->contents();
		$data['country'] = json_decode($this->Data_model->get_all_data("*","country",array("status"=>"1")),true);
		$data['state'] = json_decode($this->Data_model->get_all_data("*","state",array("status"=>"1","country_id"=>99)),true);
		$data['payment_method'] = json_decode($this->Data_model->get_all_data("*","payment_method",array("method_status"=>"1")),true);
		if(!empty($this->session->userdata('logged_in'))) {
			$where_condition=array("customer_id"=>$this->session->userdata('logged_in'));
			$get_status=json_decode($this->Data_model->get_all_data("address_id,concat(firstname,' ',lastname,',',address_1,' , ',city,', ',state.name,',',country.name,', Pincode - ',postcode) as address","address",$where_condition,array(array("state"=>"state.state_id=address.state_id"),array("country"=>"country.country_id=address.country_id"))),true);
			if($get_status['status']==1)
				{
					$data['address']=$get_status['result'];
				}
				else
				{
					$data['address']=array();
				}
		}
		else { $data['address']=array(); }
		//print_r($data);exit;
		$this->load->view('header',$header);
		$this->load->view('checkout/view',$data);
		$this->load->view('footer');
	}

	public function process()
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			//print_r($_POST);exit;
			$this->form_validation->set_rules('billing_address_option', 'Billing Address', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('shipping_address_option', 'Shipping Address', 'trim|xss_clean|strip_tags');
			$this->form_validation->set_rules('paymentmethod', 'Payment Method', 'trim|required|xss_clean|strip_tags');
			$billing_address_option=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_address_option']))));
			$paymentmethod=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['paymentmethod']))));
			$order=array("shipping_method"=>$paymentmethod,"order_status_id"=>1,"date_added"=>date("Y-m-d h:i:s"),"ip"=>$this->input->ip_address(),"total"=>$this->cart->total());
			if($billing_address_option =='new')
			{
				$this->form_validation->set_rules('billing_firstname', 'Billing Firstname', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_lastname', 'Billing Lastname', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_email', 'Billing Email', 'valid_email|trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_mobile', 'Billing mobile', 'numeric|regex_match[/^[0-9]{10}$/]|trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_address', 'Billing Address', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_country', 'Billing Country', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_state', 'Billing State', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_city', 'Billing City', 'trim|required|xss_clean|strip_tags');
				$this->form_validation->set_rules('billing_zip', 'Billing Zip', 'numeric|regex_match[/^[0-9]{6}$/]|trim|required|xss_clean|strip_tags');
				$billing_firstname=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_firstname']))));
				$billing_lastname=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_lastname']))));
				$billing_email=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_email']))));
				$billing_mobile=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_mobile']))));
				$billing_address=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_address']))));
				$billing_country=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_country']))));
				$billing_state=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_state']))));
				$billing_city=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_city']))));
				$billing_zip=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['billing_zip']))));
				$new_billing_details=array("firstname"=>$billing_firstname,"lastname"=>$billing_lastname,"address_1"=>$billing_address,"city"=>$billing_city,"postcode"=>$billing_zip,"state_id"=>$billing_state,"country_id"=>$billing_country);
				$billing_details=array("billing_firstname"=>$billing_firstname,"billing_lastname"=>$billing_lastname,"email"=>$billing_email,"telephone"=>$billing_mobile,"billing_address_1"=>$billing_address,"billing_city"=>$billing_city,"billing_postcode"=>$billing_zip,"billing_state_id"=>$billing_state,"billing_country_id"=>$billing_country);
				if(!isset($_POST['ship-to-diiferent-address']))
				{
					$shipping_details=array("shipping_firstname"=>$billing_firstname,"shipping_lastname"=>$billing_lastname,"shipping_address_1"=>$billing_address,"shipping_city"=>$billing_city,"shipping_postcode"=>$billing_zip,"shipping_state_id"=>$billing_state,"shipping_country_id"=>$billing_country);
					$order = array_merge($order,$shipping_details);
				}
			}
			else
			{
				$where_condition=array("address_id"=>$billing_address_option);
				$get_status=json_decode($this->Data_model->get_all_data("address_id,address.firstname as firstname,address.lastname as lastname,address_1,city,address.state_id as state_id,address.country_id as country_id,postcode,telephone,email","address",$where_condition,array(array("state"=>"state.state_id=address.state_id"),array("country"=>"country.country_id=address.country_id"),array("customer"=>"customer.customer_id=address.customer_id"))),true);
				if($get_status['status']==1)
				{
					$billing_email=trim(strip_tags(html_entity_decode($this->security->xss_clean($get_status['result'][0]['email']))));
					$billing_details=array("billing_firstname"=>$get_status['result'][0]['firstname'],"billing_lastname"=>$get_status['result'][0]['lastname'],"email"=>$get_status['result'][0]['email'],"telephone"=>$get_status['result'][0]['telephone'],"billing_address_1"=>$get_status['result'][0]['address_1'],"billing_city"=>$get_status['result'][0]['city'],"billing_postcode"=>$get_status['result'][0]['postcode'],"billing_state_id"=>$get_status['result'][0]['state_id'],"billing_country_id"=>$get_status['result'][0]['country_id']);
					if(!isset($_POST['ship-to-diiferent-address']))
						{
						$shipping_details=array("shipping_firstname"=>$get_status['result'][0]['firstname'],"shipping_lastname"=>$get_status['result'][0]['lastname'],"shipping_address_1"=>$get_status['result'][0]['address_1'],"shipping_city"=>$get_status['result'][0]['city'],"shipping_postcode"=>$get_status['result'][0]['postcode'],"shipping_state_id"=>$get_status['result'][0]['state_id'],"shipping_country_id"=>$get_status['result'][0]['country_id']);
						$order = array_merge($order,$shipping_details);
						}	
				}
				else
				{
					$this->session->set_flashdata('flasherror', "1 Unable to process your payment. Try after some time.");
					redirect(base_url('checkout'));exit;
				}
			}
			$order = array_merge($order,$billing_details);
			if(isset($_POST['ship-to-diiferent-address']))
			{
				$shipping_address_option=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_address_option']))));
				if($shipping_address_option =='new')
				{
					$this->form_validation->set_rules('shipping_firstname', 'Shipping Firstname', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_lastname', 'Shipping Lastname', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_address', 'Shipping Address', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_country', 'Shipping Country', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_state', 'Shipping State', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_city', 'Shipping City', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('shipping_zip', 'Shipping Zip', 'numeric|regex_match[/^[0-9]{6}$/]|trim|required|xss_clean|strip_tags');
					$shipping_firstname=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_firstname']))));
					$shipping_lastname=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_lastname']))));
					$shipping_address=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_address']))));
					$shipping_country=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_country']))));
					$shipping_state=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_state']))));
					$shipping_city=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_city']))));
					$shipping_zip=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['shipping_zip']))));
					$shipping_details=array("shipping_firstname"=>$shipping_firstname,"shipping_lastname"=>$shipping_lastname,"shipping_address_1"=>$shipping_address,"shipping_city"=>$shipping_city,"shipping_postcode"=>$shipping_zip,"shipping_state_id"=>$shipping_state,"shipping_country_id"=>$shipping_country);
					$order = array_merge($order,$shipping_details);
				}
				else
				{
					$where_condition=array("address_id"=>$shipping_address_option);
					$get_status=json_decode($this->Data_model->get_all_data("address_id,address.firstname as firstname,address.lastname as lastname,address_1,city,address.state_id as state_id,address.country_id as country_id,postcode,telephone,email","address",$where_condition,array(array("state"=>"state.state_id=address.state_id"),array("country"=>"country.country_id=address.country_id"),array("customer"=>"customer.customer_id=address.customer_id"))),true);
					if($get_status['status']==1)
					{
						$shipping_details=array("shipping_firstname"=>$get_status['result'][0]['firstname'],"shipping_lastname"=>$get_status['result'][0]['lastname'],"email"=>$get_status['result'][0]['email'],"telephone"=>$get_status['result'][0]['telephone'],"shipping_address_1"=>$get_status['result'][0]['address_1'],"shipping_city"=>$get_status['result'][0]['city'],"shipping_postcode"=>$get_status['result'][0]['postcode'],"shipping_state_id"=>$get_status['result'][0]['state_id'],"shipping_country_id"=>$get_status['result'][0]['country_id']);
						$order = array_merge($order,$shipping_details);						
					}
					else
					{
						$this->session->set_flashdata('flasherror', "2 Unable to process your payment. Try after some time.");
						redirect(base_url('checkout'));exit;
					}
				}
			}
			if($this->form_validation->run() !== false) 
			{
				if(isset($_POST['create-account']))
				{
					$get_status=json_decode($this->Data_model->get_all_data("customer_id,","customer",array("email"=>$billing_email)),true);
					if($get_status['status'] == NULL)
					{
					$this->form_validation->set_rules('password', 'Password', 'min_length[7]|max_length[10]|trim|required|xss_clean|strip_tags');
					$password=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['password']))));
					$new_account=array("firstname"=>$billing_firstname,"lastname"=>$billing_lastname,"email"=>$billing_email,"telephone"=>$billing_mobile,"status"=>1,"date_added"=>date('Y-m-d h:i:s'),"password"=>md5($password));
					$customer=json_decode($this->Data_model->insert_data($new_account,"customer"),true);
					$this->session->set_userdata("logged_in",$customer['id']);							
					}
					else
					{
					$this->session->set_flashdata('flasherror', "Oops! you are already registered with us");
					redirect(base_url('checkout'));exit;
					}
				}
				if($billing_address_option =='new')
				{
					if(!empty($this->session->userdata('logged_in')))
					{
					$new_billing_details["customer_id"]=$this->session->userdata('logged_in');
					$this->Data_model->insert_data($new_billing_details,"address");	
					}
				}
				if(isset($_POST['ship-to-diiferent-address']))
				{
					if($shipping_address_option =='new')
					{
					if(!empty($this->session->userdata('logged_in')))
						{
						$new_shipping_details=array("firstname"=>$shipping_firstname,"lastname"=>$shipping_lastname,"address_1"=>$shipping_address,"city"=>$shipping_city,"postcode"=>$shipping_zip,"state_id"=>$shipping_state,"country_id"=>$shipping_country,"customer_id"=>$this->session->userdata('logged_in'));
						$this->Data_model->insert_data($new_shipping_details,"address");		
						}
					}
				}	
				if(!empty($this->session->userdata('logged_in')))
				{
					$order = array_merge($order,array("customer_id"=>$this->session->userdata('logged_in'),"customer_group_id"=>2));
				}
				else
				{
					$order = array_merge($order,array("customer_id"=>0,"customer_group_id"=>1));
				}
				$result=json_decode($this->Data_model->insert_data($order,"order"),true);
				if($result['status']==true)
				{
					foreach($this->cart->contents() as $item)
					{
						$per_product=$item['price'];
						$product_name=$item['name'];
						$qty=$item['qty'];
						$total_per_product_price=$per_product*$qty; 
						$this->Data_model->insert_data(array("order_id"=>$result['id'],"product_id"=>$item['id'],"name"=>$product_name,"quantity"=>$qty,"price"=>$per_product,"total"=>$total_per_product_price),"order_product");
					}
					set_cookie('orderid',$result['id'],'600');
					$create_order_id = sprintf('%06d',$result['id']);
					$update_order_id="FYN".$create_order_id;
					$update_data=array("order_general_id"=>$update_order_id);
					$update_condition=array("order_id"=>$result['id']);
					$get_update=json_decode($this->Data_model->update_data('order',$update_condition,$update_data),true);
					if($get_update['status']==1)
					{
					$this->cart->destroy();	
					redirect(base_url('thankyou'));exit;
					}	
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
}	
