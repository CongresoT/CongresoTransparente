<?php
/**
  * Commission model
  *
  * This is the commission model for the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Commission/Models
  */
class Commission_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get commission list
	 *
	 * @param	array		Filters
	 * @return	array		Commission information
	 */		
	function get_list($filters)
	{
		$this->db->select('c.*')
			->from('commission c');

		if (is_array($filters))
		{			
			if (array_key_exists('search', $filters))
				$this->db->where('(c.name LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');
		}
			
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get congressmen associated to a commission
	 *
	 * @param	int			Commission ID
	 * @param	array		Filters
	 * @return	array		Commission information
	 */		
	function get_congressman($commission_id, $filters)
	{
		$this->db->select('c.congressman_id, c.names, c.last_names, cc.position')
			->from('commission_to_congressman cc')
			->join('congressman c', 'c.congressman_id=cc.congressman_id', 'inner')
			->where('cc.comission_id', $commission_id)
			->order_by('cc.order');

		if (is_array($filters))
		{			
			if (array_key_exists('search', $filters))
				$this->db->where('(c.names LIKE "%' . $this->db->escape_like_str($filters['search']) . '%" OR c.last_names LIKE "%' . $this->db->escape_like_str($filters['search']) . '%" OR cc.position LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');
		}
			
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get commission list from laws
	 *
	 * @param	none
	 * @return	array		Commission information
	 */		
	function get_list_from_laws()
	{
		$this->db->select('c.*')
			->from('commission_to_law cl')
			->join('commission c', 'c.comission_id=cl.comission_id', 'inner');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get commission list from law
	 *
	 * @param	int			Law ID
	 * @return	array		Commission information
	 */		
	function get_list_from_law($law_id)
	{
		$this->db->select('c.*')
			->from('commission_to_law cl')
			->join('commission c', 'c.comission_id=cl.comission_id', 'inner')
			->where('cl.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}
}