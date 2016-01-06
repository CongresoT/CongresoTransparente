<?php
/**
  * Vote model
  *
  * This is the main model for votes on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Vote/Models
  */
class Vote_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Gets all the current active congressmen
	 *
	 * @param	int			Law ID
	 * @return	array		Congressmen information
	 */		
	function get_votes($law_id)
	{
		$this->db->select('v.law_id, v.congressman_id, v.date, v.vote_result_id, vr.name AS result_name, c.names, c.last_names, c.photo')
			->from('vote v')
			->join('vote_result vr', 'vr.vote_result_id=v.vote_result_id', 'left')
			->join('congressman c', 'c.congressman_id=v.congressman_id', 'left')
			->where('v.law_id', $law_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Gets all the current active congressmen
	 *
	 * @param	int			Law ID
	 * @param	int			Congressman ID
	 * @param	date		Vote date
	 * @param	int			Vote Result ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function insert_vote($law_id, $congressman_id, $vote_date, $vote_result_id)
	{
		
		if ($vote_date == null)
			$vote_date = 'null';
		else
			$vote_date = "'$vote_date'";
		
		$this->db->query("INSERT INTO vote (law_id, congressman_id, `date`, vote_result_id) VALUES ($law_id, $congressman_id, $vote_date, $vote_result_id) ON DUPLICATE KEY UPDATE `date`=$vote_date, vote_result_id=$vote_result_id;");

        return ($this->db->_error_number() == 0);
	}
	
	/**
	 * Gets congressmen not included in the vote session
	 *
	 * @param	int			Law ID
	 * @return	array		Congressmen information
	 */		
	function get_eligible_congressmen($law_id)
	{
		$this->db->select('c.congressman_id, v.date, v.vote_result_id, c.names, c.last_names')
			->from('congressman c')
			->join('vote v', 'c.congressman_id=v.congressman_id AND v.law_id=' . intval($law_id), 'left')
			->where('v.congressman_id IS NULL');

        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}	

	/**
	 * Searchs congressmen not included in the vote session
	 *
	 * @param	int			Law ID
	 * @param	string		Search string
	 * @param	int			Page
	 * @return	array		Congressmen information
	 */		
	function search_eligible_congressmen($law_id, $searchstring = "", $page = 0)
	{
		$this->db->select('COUNT(*) total')
			->from('congressman c')
			->join('vote v', 'c.congressman_id=v.congressman_id AND v.law_id=' . intval($law_id), 'left')
			->where('v.congressman_id IS NULL');
			
		if ($searchstring != "")
			$this->db->where('(c.names LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR c.last_names LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');
	
        $query = $this->db->get();

		$data	= (object) array('total' => 0,
							'congressmen' => array());
		
        if ($query->num_rows() > 0)
		{
			$row 			= $query->row();
			$data->total 	= $row->total;

			$this->db->select('c.congressman_id as id, c.congressman_id, c.photo, v.date, v.vote_result_id, c.names, c.last_names')
				->from('congressman c')
				->join('vote v', 'c.congressman_id=v.congressman_id AND v.law_id=' . intval($law_id), 'left')
				->where('v.congressman_id IS NULL')
				->limit(10, $page * 10);
				
			if ($searchstring != "")
				$this->db->where('(c.names LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR c.last_names LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');

			$query	= $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				$data->congressmen = $query->result();
			}
		}
		
		return $data;
	}	
	
	/**
	 * Deletes a congressman from the vote list
	 *
	 * @param	int			Law ID
	 * @param	int			Congressman ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function delete_vote($law_id, $congressman_id)
	{
		$where = array('law_id' => $law_id,
			'congressman_id' => $congressman_id);
		
		$this->db->delete('vote', $where);

        return ($this->db->_error_number() == 0);
	}	

	/**
	 * Deletes all congressmen from the vote list
	 *
	 * @param	int			Law ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function delete_all($law_id)
	{
		$where = array('law_id' => $law_id);
		
		$this->db->delete('vote', $where);

        return ($this->db->_error_number() == 0);
	}	
}