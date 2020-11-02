<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

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
		$header['page_title']="Cart";
		$header['page_description']="Cart Page";
		$header['count']=count($this->cart->contents());
		$data['cart'] = $this->cart->contents(); 
		$this->load->view('header',$header);
		$this->load->view('cart/view',$data);
		$this->load->view('footer');

	}

	public function add($param='')
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->form_validation->set_rules('id', 'Product Id', 'numeric|trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('quantity', 'Product quantity', 'numeric|trim|required|xss_clean|strip_tags');
			if($this->form_validation->run() !== false) 
			{
				$id=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['id']))));
				$quantity=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['quantity']))));
				$result = $this->curl->simple_get('https://fakestoreapi.com/products/'.$id);
				if(!empty($result))
				{
					$data_decode=json_decode($result,true);
					$data = array(
					'id'    => $data_decode['id'],
					'qty'    => $quantity,
					'price'    => $data_decode['price'],
					'name'    => $data_decode['title'],
					'image' => $data_decode['image']
					);
					foreach($this->cart->contents() as $item){
	    				if($item['id'] == $data_decode['id']){
	       					$item['qty'] = 0;
	        				$this->cart->update($item);
	    				}
					}
      				if($this->cart->insert($data))
      				{
      					$finresult =  array( 'status'=>'success', 'message'=> "Added to Cart",'count'=>count($this->cart->contents()));
						echo json_encode($finresult);	
      				}
      				else
      				{
      					$finresult =  array( 'status'=>'failed', 'message'=> "Sorry! Product you selected is out of stock.",'count'=>count($this->cart->contents()));
						echo json_encode($finresult);
      				}
				}
				else
				{
					$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
					echo json_encode($finresult);
				}

			}
			else
			{
				$errors = array();
				$string="";
				$errors = $this->form_validation->error_array();
				foreach($errors as $key=>$value){	$string .= $value.'<br/>'; }
				$finresult =  array( 'status'=>'failed', 'message'=> $string );
				echo json_encode($finresult);	
			}
		}
		else
		{
			$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
			echo json_encode($finresult);
		}
	}

	public function update($param='')
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->form_validation->set_rules('id', 'Product Id', 'numeric|trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('quantity', 'Product quantity', 'numeric|trim|required|xss_clean|strip_tags');
			if($this->form_validation->run() !== false) 
			{
				$id=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['id']))));
				$quantity=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['quantity']))));
				$result = $this->curl->simple_get('https://fakestoreapi.com/products/'.$id);
				if(!empty($result))
				{
					$data_decode=json_decode($result,true);
					$data = array(
					'id'    => $data_decode['id'],
					'qty'    => $quantity,
					'price'    => $data_decode['price'],
					'name'    => $data_decode['title'],
					'image' => $data_decode['image']
					);
					foreach($this->cart->contents() as $item){
	    				if($item['id'] == $data_decode['id']){
	       					$item['qty'] = 0;
	        				$this->cart->update($item);
	    				}
					}
      				if($this->cart->insert($data))
      				{
      					$finresult =  array( 'status'=>'success', 'message'=> "Added to Cart",'count'=>count($this->cart->contents()));
						echo json_encode($finresult);	
      				}
      				else
      				{
      					$finresult =  array( 'status'=>'failed', 'message'=> "Sorry! Product you selected is out of stock.",'count'=>count($this->cart->contents()));
						echo json_encode($finresult);
      				}
				}
				else
				{
					$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
					echo json_encode($finresult);
				}

			}
			else
			{
				$errors = array();
				$string="";
				$errors = $this->form_validation->error_array();
				foreach($errors as $key=>$value){	$string .= $value.'<br/>'; }
				$finresult =  array( 'status'=>'failed', 'message'=> $string );
				echo json_encode($finresult);	
			}
		}
		else
		{
			$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
			echo json_encode($finresult);
		}
	}


	public function delete($param='')
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$this->form_validation->set_rules('id', 'Product Id', 'numeric|trim|required|xss_clean|strip_tags');
			if($this->form_validation->run() !== false) 
			{
				$id=trim(strip_tags(html_entity_decode($this->security->xss_clean($_POST['id']))));
				$result = $this->curl->simple_get('https://fakestoreapi.com/products/'.$id);
				if(!empty($result))
				{
					$data_decode=json_decode($result,true);
					foreach($this->cart->contents() as $item){
	    				if($item['id'] == $data_decode['id']){
	       					$item['qty'] = 0;
	        				$this->cart->update($item);
	        				break;
	    				}
					}
      				$finresult =  array( 'status'=>'success', 'message'=> "Removed from Cart",'count'=>count($this->cart->contents()));
					echo json_encode($finresult);
				}
				else
				{
					$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
					echo json_encode($finresult);
				}

			}
			else
			{
				$errors = array();
				$string="";
				$errors = $this->form_validation->error_array();
				foreach($errors as $key=>$value){	$string .= $value.'<br/>'; }
				$finresult =  array( 'status'=>'failed', 'message'=> $string );
				echo json_encode($finresult);	
			}
		}
		else
		{
			$finresult =  array( 'status'=>'failed', 'message'=> "We are terribly sorry, but the product you selected is not available right now to purchase." );
			echo json_encode($finresult);
		}
	}
}	
