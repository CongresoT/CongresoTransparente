<?php

class Parameter_model extends CI_Model {

    function  __construct() {
        parent::__construct();
    }

/**
 * Get parameters
 *
 * Gets parameters.
 * @param	none
 * @return	array	Data
 */	
	function get_parameters(){
		$this->db->select('key, value')
		->from('parameter');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$parameters = array();
			$data = $query->result();
			foreach ($data as $p)
			{
				$parameters[$p->key] = $p->value;
			}
			return $parameters;
		}
		
		return array();
    }
}