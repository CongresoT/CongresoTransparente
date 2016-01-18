<?php
/**
  * Law model
  *
  * This is the law model for content on the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Law/Models
  */
class Law_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get a law data
	 *
	 * @param	int		Law ID
	 * @return	array	Laws information
	 */		
	function get($law_id)
	{
		$this->db->select('l.law_id, l.number, l.name, l.presentation_date, l.description, l.status_id law_status_id, ls.name law_status, lt.name law_type, c.name commission', FALSE)
			->from('law l')
			->join('law_status ls', 'l.status_id=ls.status_id', 'inner')
			->join('law_type lt', 'l.law_type_id=lt.law_type_id', 'inner')
			->join('commission_to_law cl', 'l.law_id=cl.law_id', 'left')
			->join('commission c', 'c.comission_id=cl.comission_id', 'left')
			->where('l.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->row();
		}
        else
            return FALSE;
	}

	/**
	 * Get a list of congressmen
	 *
	 * @param	array		Filters
	 * @return	array		Congressmen information
	 */		
	function get_list($filters = '')
	{
		$this->db->select('l.law_id, l.number, l.name, l.presentation_date, l.status_id law_status_id, ls.name law_status, lt.name law_type, c.name commission')
			->from('law l')
			->join('law_status ls', 'l.status_id=ls.status_id', 'inner')
			->join('law_type lt', 'l.law_type_id=lt.law_type_id', 'inner')
			->join('commission_to_law cl', 'l.law_id=cl.law_id', 'left')
			->join('commission c', 'c.comission_id=cl.comission_id', 'left');
	
		if (is_array($filters))
		{
			if (array_key_exists('law_type_id', $filters))
				$this->db->where('l.law_type_id', $filters['law_type_id']);

			if (array_key_exists('law_status_id', $filters))
				$this->db->where('l.status_id', $filters['law_status_id']);

			if (array_key_exists('commission_id', $filters))
				$this->db->where('cl.commission_id', $filters['commission_id']);

			if (array_key_exists('search', $filters))
				$this->db->where('(l.name LIKE "%' . $this->db->escape_like_str($filters['search']) . '%" OR l.number LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');
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
	 * Get congressmen data associated to law
	 *
	 * @param	int		Law ID
	 * @return	array	Congressmen information
	 */		
	function get_congressmen($law_id)
	{
		$this->db->select('c.congressman_id, c.names, c.last_names')
			->from('law_to_congressman lc')
			->join('congressman c', 'c.congressman_id=lc.congressman_id', 'inner')
			->where('lc.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}	

	/**
	 * Get persons data associated to law
	 *
	 * @param	int		Law ID
	 * @return	array	Persons information
	 */		
	function get_persons($law_id)
	{
		$this->db->select('lp.full_name')
			->from('law_to_person lp')
			->where('lp.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}	
	
	/**
	 * Get a list of votes from a congressman
	 *
	 * @param	int			Law ID
	 * @param	array		Filter parameters
	 * @return	array		Votes information
	 */		
	function get_votes($law_id, $filters = "")
	{
		$this->db->select('c.congressman_id, v.vote_result_id, vr.name vote_result_name, c.names, c.last_names, pp.short_name political_party')
			->from('vote v')
			->join('vote_result vr', 'v.vote_result_id=vr.vote_result_id', 'inner')
			->join('commission_to_law cl', 'v.law_id=cl.law_id', 'left')
			->join('congressman c', 'c.congressman_id=v.congressman_id', 'left')
			->join('congressman_to_political_party cpp', 'c.congressman_id=cpp.congressman_id', 'left')
			->join('political_party pp', 'pp.political_party_id=cpp.political_party_id', 'left')
			->where('((SELECT IFNULL(MAX(IFNULL(cppsq.date_end, "9999-12-31 23:59:59")), "9999-12-31 23:59:59") FROM congressman_to_political_party cppsq WHERE cppsq.congressman_id=c.congressman_id) = IFNULL(cpp.date_end, "9999-12-31 23:59:59"))')
			->where('v.law_id', $law_id);

		if (is_array($filters))
		{
			if (array_key_exists('political_party_id', $filters))
				$this->db->where('pp.political_party_id', $filters['political_party_id']);			
			
			if (array_key_exists('search', $filters))
				$this->db->where('(c.names LIKE "%' . $this->db->escape_like_str($filters['search']) . '%" OR c.last_names LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');			
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
	 * Get a list of all rulings
	 *
	 * @param	int			Law ID
	 * @param	array		Filter parameters	 
	 * @return	array		Ruling information
	 */		
	function get_rulings($law_id, $filters = "")
	{
		$this->db->select('r.law_id, r.description, r.creation_date, c.name')
			->from('ruling r')
			->join('law l', 'r.law_id=r.law_id', 'inner')
			->join('commission c', 'c.comission_id=r.comission_id', 'left')
			->where('r.law_id', $law_id);
	
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
	 * Get a law's timeline
	 *
	 * @param	int			Law ID
	 * @return	array		Law timeline information
	 */		
	function get_timeline($law_id)
	{
		$this->db->select('lt.name, lt.description, lt.date')
			->from('law_timeline lt')
			->where('lt.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}
}