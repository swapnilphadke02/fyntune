<?php
class Data_model extends CI_Model 
{
	
	function insert_data( $insert_data, $table )
    {	
		if($this->db->insert($table, $insert_data))
		{
			return json_encode(array("status"=>true,"message"=>"Inserterd Successfully","id"=>$this->db->insert_id()));
		}
		else
		{
			return json_encode(array("status"=>false,"message"=>"Inserterd Failed","id"=>NULL));
		}
	}
	   
	function update_data($table,$where_data,$update_data) 
	{
		if($table !="" && isset($where_data) && !empty($update_data))
		{	
			$this->db->where($where_data);
			if($this->db->update($table, $update_data))
			{	
				return json_encode(array("status"=>true,"message"=>"Data is updated","id"=>NULL));
			}
			else
			{
				return json_encode(array("status"=>false,"message"=>"Data condition is wrong","id"=>NULL));
			}	
		}
		else
		{
			return json_encode(array("status"=>false,"message"=>"Data Missing","id"=>NULL));
		}		
	}

	public function get_row_count($table) 
	{
        return $this->db->count_all($table);
    }
    
	public function get_all_data($select_data,$table,$where_data="",$join="",$group_by="",$order_by="",$limitstart="",$limitend="") 
	{
		$this->db->select($select_data);    
		$this->db->from($table);
		if(isset($join) && !empty($join))
		{
			for($i=0;$i<=count($join)-1;$i++)
	        {			
				foreach($join[$i] as $data => $values);
				{
					$this->db->join($data,$values);		
				}
			}
		}
		if(isset($where_data) && !empty($where_data))
		{	
			$this->db->where($where_data);
		}
		if(isset($group_by) && !empty($group_by)) 
		{	
			$this->db->group_by($group_by);
		}
		if(isset($order_by) && !empty($order_by))
		{	
			$this->db->order_by($order_by[0],$order_by[1]);
		}	
		if(isset($limitstart) && !empty($limitend))
		{	
			$this->db->limit($limitend, $limitstart);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{	
			$result = $query->result_array(); 
			return json_encode(array("status"=>true,"message"=>"Data Found","result"=>$result));
		}
		else
		{
			$result=array();
			return json_encode(array("status"=>false,"message"=>"No Results Found","result"=>$result));
		}
	}

	function delete_data($table,$where_data) {
		if(isset($where_data) && !empty($where_data))
		{	
			$this->db->where($where_data);
			$result=$this->db->delete($table);
			if($result)
			{	
				return true;
			}
			else
			{
				return false;	
			}	
		}
		else
		{
			return false;	
		}		 
	}
}