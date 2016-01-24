<?php
/**
  * Congressman model
  *
  * This is the main model for content on the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Congressman/Models
  */
class Congressman_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get a congressman data
	 *
	 * @param	int		Congressman ID
	 * @return	array		Congressmen information
	 */		
	function get($congressman_id)
	{
		$this->db->select('c.*, pp.full_name party_name, pp.short_name party_short_name, s.name, pp.color, pp.logo, d.name as district_name, TIMESTAMPDIFF(YEAR, c.birthday, CURDATE()) age', FALSE)
			->from('congressman c')
			->join('congressman_to_political_party cpp', 'c.congressman_id=cpp.congressman_id', 'left')
			->join('political_party pp', 'pp.political_party_id=cpp.political_party_id', 'left')
			->join('district d', 'd.district_id=c.district_id', 'left')
			->join('sex s', 's.sex_id=c.sex_id', 'left')
			->where('((SELECT IFNULL(MAX(IFNULL(cppsq.date_end, "9999-12-31 23:59:59")), "9999-12-31 23:59:59") FROM congressman_to_political_party cppsq WHERE cppsq.congressman_id=c.congressman_id) = IFNULL(cpp.date_end, "9999-12-31 23:59:59"))')
			->where('c.congressman_id', $congressman_id);
	
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
		$this->db->select('c.*, pp.full_name party_name, pp.short_name party_short_name, s.name, pp.color, pp.logo, d.name as district_name')
			->from('congressman c')
			->join('congressman_to_political_party cpp', 'c.congressman_id=cpp.congressman_id', 'left')
			->join('political_party pp', 'pp.political_party_id=cpp.political_party_id', 'left')
			->join('district d', 'd.district_id=c.district_id', 'left')
			->join('sex s', 's.sex_id=c.sex_id', 'left')
			->where('((SELECT IFNULL(MAX(IFNULL(cppsq.date_end, "9999-12-31 23:59:59")), "9999-12-31 23:59:59") FROM congressman_to_political_party cppsq WHERE cppsq.congressman_id=c.congressman_id) = IFNULL(cpp.date_end, "9999-12-31 23:59:59"))');
	
		if (is_array($filters))
		{
			if (array_key_exists('active', $filters))
				$this->db->where('c.active', $filters['active']);

			if (array_key_exists('district_id', $filters))
				$this->db->where('c.district_id', $filters['district_id']);

			if (array_key_exists('political_party_id', $filters))
				$this->db->where('cpp.political_party_id', $filters['political_party_id']);

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
	 * Get a list of votes from a congressman
	 *
	 * @param	int			Congressman ID
	 * @param	array		Filter parameters
	 * @return	array		Votes information
	 */		
	function get_votes($congressman_id, $filters = "")
	{
		$this->db->select('l.law_id, l.name, l.number, v.vote_result_id, vr.name AS vote_result_name')
			->from('vote v')
			->join('vote_result vr', 'v.vote_result_id=vr.vote_result_id', 'inner')
			->join('law l', 'l.law_id=v.law_id', 'inner')
			->join('law_type lt', 'lt.law_type_id=l.law_type_id', 'inner')
			->where('v.congressman_id', $congressman_id);

		if (is_array($filters))
		{
			if (array_key_exists('law_type_id', $filters))
			{
				if ($filters['law_type_id'] > 0)
					$this->db->where('l.law_type_id', $filters['law_type_id']);
			}

			if (array_key_exists('search', $filters))
				$this->db->where('(lt.name LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');
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
	 * Get a list of attendance from a congressman
	 *
	 * @param	int			Congressman ID
	 * @return	array		Attendance information
	 */		
	function get_attendance($congressman_id)
	{
		$this->db->select('SUM(IF(a.congressman_id IS NULL, 0, 1)) total, ast.attendance_state_id, ast.name, ast.color', FALSE)
			->from('attendance_state ast')
			->join('attendance a', 'ast.attendance_state_id=a.attendance_state_id AND ' . 'a.congressman_id=' . intval($congressman_id), 'left')
			->group_by('ast.attendance_state_id')
			->order_by('ast.order');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get a list of political parties
	 *
	 * @param	int			Congressman ID
	 * @return	array		Political parties information
	 */		
	function get_political_parties($congressman_id)
	{
		$this->db->select('cpp.date_begin, cpp.date_end, pp.full_name, pp.short_name, pp.color, pp.logo', FALSE)
			->from('congressman_to_political_party cpp')
			->join('political_party pp', 'pp.political_party_id=cpp.political_party_id', 'left')
			->where('cpp.congressman_id', $congressman_id)
			->order_by('cpp.date_begin');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get a list of presented laws
	 *
	 * @param	int			Congressman ID
	 * @param	array		Filter parameters
	 * @return	array		Laws information
	 */		
	function get_laws($congressman_id, $filters = "")
	{
		$this->db->select('l.law_id, l.number, l.name')
			->from('law_to_congressman lc')
			->join('law l', 'l.law_id=lc.law_id', 'inner')
			->join('law_type lt', 'lt.law_type_id=l.law_type_id', 'inner')
			->where('lc.congressman_id', $congressman_id);

		if (is_array($filters))
		{
			if (array_key_exists('law_type_id', $filters))
			{
				if ($filters['law_type_id'] > 0)
					$this->db->where('l.law_type_id', $filters['law_type_id']);
			}

			if (array_key_exists('search', $filters))
				$this->db->where('(lt.name LIKE "%' . $this->db->escape_like_str($filters['search']) . '%")');
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
	 * Get a list of citations
	 *
	 * @param	int			Congressman ID
	 * @param	array		Filter parameters
	 * @return	array		Citations information
	 */		
	function get_citations($congressman_id, $filters = "")
	{
		$this->db->select('c.citation_id, c.subject, c.attachment, c.audio')
			->from('citation c')
			->where('c.congressman_id', $congressman_id);

		if (is_array($filters))
		{
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
	 * Get a list of commissions
	 *
	 * @param	int			Congressman ID
	 * @param	array		Filter parameters
	 * @return	array		Commission information
	 */		
	function get_comissions($congressman_id, $filters = "")
	{
		$this->db->select('c.comission_id, c.name, cc.position, c.date')
			->from('commission_to_congressman cc')
			->join('commission c', 'cc.comission_id=c.comission_id', 'inner')
			->where('cc.congressman_id', $congressman_id);

		if (is_array($filters))
		{
		}
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}
}