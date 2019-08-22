<?php
// Design for : Oracle System
class Base_model extends CI_Model 
{
	public $table = '';
	public $pk_field = '';
	public $code_field = '';
	public $limit = 0;
	public $offset = 0;
	public $where = array();
	public $where_not = array();
	public $where_in = array();
	public $like = array();
	//buka jadi true jika app log akan diaktifkan lagi
	public $is_trap = false;
	public $table_select = '';
    
	function __construct() 
	{
        parent::__construct();

    }
	
	function count() 
	{
		$data = array();
	
		$this->db->where($this->where);
		$this->db->or_like($this->like);
		
		$query = $this->db->get($this->table.' t1');
	
		return $query->num_rows();
	}
	
	function get($where) 
	{
		$data = array();
	
		if ( is_array($where) )
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}else
		{
			$this->db->where($this->pk_field, $where);
		}
		$this->db->select('TBL.*');
		
		if ($this->is_trap)
		{
			$this->db->select('LG.ID_LOG');
			$sql_log = "(SELECT max(T_LOG.ID_LOG) as ID_LOG,T_LOG.FID_DATA
							FROM T_APP_LOG T_LOG 
							WHERE T_LOG.TABLE_NAME = '".$this->table."' 
							GROUP BY T_LOG.FID_DATA) LG";
			$this->db->join($sql_log,'TBL.'.$this->pk_field.' = LG.FID_DATA','left');
		}else{
			$this->db->select('CAST(0 AS NUMBER) AS ID_LOG');
		}
		$query = $this->db->get($this->table.' "TBL"');
		// echo $this->db->last_query();
		
		 if ( $query->num_rows() == 1)
		{
            $data = $query->row_array();
			$query->free_result();
			
		}else
		{
			$data = $this->feed_blank();
			$data['ID_LOG'] = 0;
		}
        return $data;
	}
	
	public function set_table($table)
	{
		$this->table = $table;
	}
	
	public function set_log($trap, $table_select = '')
	{
		//$trap remark jika app log akan diaktifkan
		//$trap = false;
		$this->is_trap = $trap;
		$this->table_select = $table_select;
	}
	
	public function set_pk($table)
	{
		$this->pk_field = $table;
	}
	
	public function set_code($table)
	{
		$this->code_field = $table;
	}
	
	public function set_limit($limit=0)
	{
		if ($limit > 0)
			$this->limit = $limit;
	}
	
	public function set_offset($offset=0)
	{
		if ($offset > 0)
			$this->offset = $offset;
	}
	
	public function set_where($where=array())
	{
		if ($where)
			$this->where = $where;
	}
	public function set_like($like=array())
	{
		if ($like)
		{
			$this->like = $like;
		}
	}
	
	// ditambah oleh 
	public function set_wherein($where_in = array())
	{
		if($where_in)
		{
			$this->where_in = $where_in;
		}
	}
	public function set_not_like($notlike=array())
	{
		if ($notlike)
		{
			$this->not_like = $notlike;
		}
	}
	public function set_where_not_in($where_not=array())
	{
		if($where_not)
		{
			$this->where_not_in = $where_not;
		}
	}
	/*
	public function set_like($like=array())
	{
		if ($like)
		{
			$where = '( ';
			$i = 0;
			foreach($like as $key => $value)
			{
				if ($i>0)
					$where .= ' OR ';
					
				if ($value)
				{
					$where .= " $key LIKE '%".$value."%'";
					$i++;
				}
			}
			$where .= ' )';
			if ($i)
				$this->where[$where] = null;
			//$this->like = $like;
		}
	}
	*/
	function log($type='',$old_value='',$fid_data=0)
	{
		$data['VALUE_BEFORE'] = $old_value;
		$data['LOG_TYPE'] = $type;
		$data['IP_COMP'] = $this->input->ip_address();
		$data['FID_OPERATOR'] = $this->session->userdata('ID_USER');
		$data['TABLE_NAME'] = $this->table;
		$data['FID_DATA'] = $fid_data;
		// $this->db->insert('T_APP_LOG', $data);
		$nm_table = $this->table_select;
		
		if(!$nm_table)
		{
			$nm_table = 'T_APP_LOG';
		}			
		$this->db->insert($nm_table, $data);
	}
	function save($data)
	{
		$data = $this->clean_data($data);
		if (isset($data[$this->pk_field]))
		{
			if($data[$this->pk_field])
			{
				//get old value
				$value_old =  $this->get($data[$this->pk_field]);
				// update row
				$where[$this->pk_field] = $data[$this->pk_field];
				$this->db->where($where);
				$update = $this->db->update($this->table,$data);
				///return 'ok_'.date('s');
				if ($update)
				{
					// $this->is_trap = false;
					if ($this->is_trap)
					{
						// get new value
						$value_new =  $this->get($data[$this->pk_field]);
						// compare value
						$value_canged = array_diff($value_old,$value_new);
						$value = $value_canged;
						$arr = array_diff($value_old,$value_new);
						$var = '';
						foreach ($arr as $key => $value)
							{
								$var .= $key.' : '.$value.' => '.$value_new[$key].'; ';
							}
						if (!$var)
							$var = 'nothing has changed';
							
						$this->log('update',$var,$data[$this->pk_field]);
					}
					return $data[$this->pk_field];	
				}
				else
				{
					return false;
				}
			}else{
				// insert new row
				$insert = $this->db->insert($this->table, $data);
				if ($insert)
				{
					// jika Auto Increment tidak aktif, maka akan dibuatkan ID baru
					$query = 'select '.$this->pk_field.' from '.$this->table.' where '.$this->pk_field.' = 0';
					$data_query = $this->db->query($query);
					if ( $data_query->num_rows() == 1)
					{
						$new_id = $this->get_last_id() + 1;
						$query = 'update '.$this->table.' set '.$this->pk_field.' = '.$new_id.' where '.$this->pk_field.' = 0';
						$data_query = $this->db->query($query);
					}
					$new_id = $this->get_last_id();	
					// $this->is_trap = false;					
					if ($this->is_trap)
					{
						$this->log('insert','',$new_id);
					}
					return $new_id;				
				}
				else
				{
					return false;
				}
			}
		}else
		{
			return false;
		}
	}
	
	// function insert new data
	public function insert($data = null)
	{
		return $this->db->insert($this->table, $data);
	}
	
	public function delete($where = NULL, $table = FALSE)
	{
		$table = (FALSE !== $table) ? $table : $this->table;
		
		if ( is_array($where) )
		{
			$this->db->where($where);
		}
		else
		{
			$this->db->where($this->pk_field, $where);
		}
	
		return $this->db->delete($table);
				
		//return (int) $this->db->affected_rows();
	}
	
	function clean_data($value, $table = FALSE)
	{
		/* $data = $value;
		*/
		$data = array();
		foreach($value as $key => $val)
        {	
            if(!is_array($val))
            {
                $data[$key]     = $val;
                $data[$key]     = strip_image_tags($data[$key]);
                $data[$key]     = quotes_to_entities($data[$key]);
                $data[$key]     = encode_php_tags($data[$key]);
                $data[$key]     = trim($data[$key]);
            }
        }		
       
		$cleaned_data = array();
	
		if ( ! empty($data))
		{
			$table = ($table !== FALSE) ? $table : $this->table;
			
			$fields = $this->db->list_fields($table);
			
			$fields = array_fill_keys($fields,'');
	
			$cleaned_data = array_intersect_key($data, $fields);
		}
		return $cleaned_data;
	}
	
	function feed_blank()
	{
		$template = array();
		$fields = $this->db->list_fields($this->table);

		$fields_data = $this->field_data($this->table);

		foreach ($fields as $field)
		{
			//$field_data = array_values(array_filter($fields_data, create_function('$row', 'return $row["Field"] == "'. $field .'";')));
			$field_data = (isset($field_data[0])) ? $field_data[0] : false;

			$template[$field] = (isset($field_data['Default'])) ? $field_data['Default'] : '';
		}
		return $template;
	}
	
	function field_data($table)
	{
		return $this->db->list_fields($table);
	}
	
	function get_last_id()
	{
		$query = 'SELECT max("'.$this->pk_field.'") as "maxid" 
					FROM "'.$this->table.'"';
		$query = $this->db->query($query);
		$row = $query->row();
		$maxid = $row->maxid ?: 0;
		return $row->maxid; 		
	}
	function get_last_no($pref)
	{
		// parshing
		$pref_ln = strlen($pref);
		$table = $this->table;
		$field = $this->code_field;
		// query
		$sql = "SELECT MAX($field) $field
				FROM $table
				WHERE SUBSTR(TRIM($field),1,$pref_ln) = '$pref'
				ORDER BY $field ASC
				";

		$query = $this->db->query($sql);
		$result = 0;
		if ($query->num_rows()==1)
		{
			$returns = $query->result_array();
			foreach($returns as $return):
				$result = $return[$field];
			endforeach;
		}
		return $result;
	}
}