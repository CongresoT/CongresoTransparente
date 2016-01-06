<?php
/**
  * Congress_session model
  *
  * This is the main model for congress_sessions on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Congress_session/Models
  */
class Congress_session_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get a specific congress_session
	 *
	 * @param	int			Congress_session ID
	 * @return	array		Congressmen information
	 */		
	function get_congress_session($congress_session_id)
	{
		$this->db->select('cs.*, cs.congress_session_id as id, css.name state, CONCAT(DATE_FORMAT(cs.date_begin, "%d/%m/%Y %T"), " a ", DATE_FORMAT(cs.date_end, "%d/%m/%Y %T")) name', FALSE)
			->from('congress_session cs')
			->join('congress_session_state css', 'cs.state_id=css.congress_session_state_id', 'left')
			->where('cs.congress_session_id', $congress_session_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->row();
		}
        else
            return FALSE;
	}

	/**
	 * Searches congress_sessions
	 *
	 * @param	string		Search string
	 * @param	int			Page
	 * @return	array		Congressmen information
	 */		
	function search_congress_sessions($searchstring = "", $page = 0)
	{
		$this->db->select('COUNT(*) total')
			->from('congress_session cs')
			->join('congress_session_state css', 'cs.state_id=css.congress_session_state_id', 'left');
			
		if ($searchstring != "")
			$this->db->where('(css.name LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR CONCAT(DATE_FORMAT(cs.date_begin, "%d/%m/%Y"), " a ", DATE_FORMAT(cs.date_end, "%d/%m/%Y")) LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');

        $query = $this->db->get();

		$data	= (object) array('total' => 0,
							'congress_sessions' => array());
		
        if ($query->num_rows() > 0)
		{
			$row 			= $query->row();
			$data->total 	= $row->total;

			$this->db->select('cs.*, cs.congress_session_id as id, css.name state, CONCAT(DATE_FORMAT(cs.date_begin, "%d/%m/%Y %T"), " a ", DATE_FORMAT(cs.date_end, "%d/%m/%Y %T")) name', FALSE)
				->from('congress_session cs')
				->join('congress_session_state css', 'cs.state_id=css.congress_session_state_id', 'left');
				
			if ($searchstring != "")
				$this->db->where('(css.name LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR CONCAT(DATE_FORMAT(cs.date_begin, "%d/%m/%Y"), " a ", DATE_FORMAT(cs.date_end, "%d/%m/%Y")) LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');

			$query	= $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				$data->congress_sessions = $query->result();
			}
		}
		
		return $data;
	}	
}