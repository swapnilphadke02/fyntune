<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
		$header['count']=count($this->cart->contents());
		$header['page_title']="Products";
		$header['page_description']="Products - Fyntune Solution";
		$result = $this->curl->simple_get('https://fakestoreapi.com/products?limit=12');
		if(!empty($result))
		{
			$data_decode=json_decode($result,true);
			$data['products']=array("count"=>count($data_decode),"list"=>$data_decode);
		}
		else
		{
			$data['products']=array("count"=>0,"list"=>0);
		}	
		$this->load->view('header',$header);
		$this->load->view('product/list',$data);
		$this->load->view('footer');
	}

	public function single($param='')
	{
		if($param != '')
		{
			$result = $this->curl->simple_get('https://fakestoreapi.com/products/'.$param);
			if(!empty($result))
			{
				$data_decode=json_decode($result,true);
				$header['page_title']=$data_decode['title'];
				$header['page_description']=substr($data_decode['title'],0,160);
				$header['count']=count($this->cart->contents());
				$data['product']=array("count"=>count($data_decode),"detail"=>$data_decode);
				$this->load->view('header',$header);
				$this->load->view('product/single-product',$data);
				$this->load->view('footer');
			}
			else
			{
				$data['product']=array("count"=>0,"detail"=>0);
				redirect(base_url('product'));exit;
			}
		}
		else
		{
		redirect(base_url('custom_error/my_404'));exit;
		}
	}
}
