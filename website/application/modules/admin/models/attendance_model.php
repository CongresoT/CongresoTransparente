<?php
/**
  * Attendance model
  *
  * This is the main model for attendances on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Attendance/Models
  */
class Attendance_model extends CI_Model {

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
	function get_attendances($congress_session_id)
	{
		$this->db->select('a.congress_session_id, a.congressman_id, a.attendance_state_id, ast.name AS result_name, c.names, c.last_names, c.photo')
			->from('attendance a')
			->join('attendance_state ast', 'ast.attendance_state_id=a.attendance_state_id', 'left')
			->join('congressman c', 'c.congressman_id=a.congressman_id', 'left')
			->where('a.congress_session_id', $congress_session_id);
	
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
	 * @param	int			Attendance Result ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function insert_attendance($congress_session_id, $congressman_id, $attendance_state_id)
	{		
		$this->db->query("INSERT INTO attendance (congress_session_id, congressman_id, attendance_state_id) VALUES ($congress_session_id, $congressman_id, $attendance_state_id) ON DUPLICATE KEY UPDATE attendance_state_id=$attendance_state_id;");

        return ($this->db->_error_number() == 0);
	}
	
	/**
	 * Gets congressmen not included in the attendance session
	 *
	 * @param	int			Law ID
	 * @return	array		Congressmen information
	 */		
	function get_eligible_congressmen($congress_session_id)
	{
		$this->db->select('c.congressman_id, a.attendance_state_id, c.names, c.last_names')
			->from('congressman c')
			->join('attendance a', 'c.congressman_id=a.congressman_id AND a.congress_session_id=' . intval($congress_session_id), 'left')
			->where('a.congressman_id IS NULL');

        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}	

	/**
	 * Searchs congressmen not included in the attendance session
	 *
	 * @param	int			Law ID
	 * @param	string		Search string
	 * @param	int			Page
	 * @return	array		Congressmen information
	 */		
	function search_eligible_congressmen($congress_session_id, $searchstring = "", $page = 0)
	{
		$this->db->select('COUNT(*) total')
			->from('congressman c')
			->join('attendance a', 'c.congressman_id=a.congressman_id AND a.congress_session_id=' . intval($congress_session_id), 'left')
			->where('a.congressman_id IS NULL');
			
		if ($searchstring != "")
			$this->db->where('(c.names LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR c.last_names LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');
	
        $query = $this->db->get();

		$data	= (object) array('total' => 0,
							'congressmen' => array());
		
        if ($query->num_rows() > 0)
		{
			$row 			= $query->row();
			$data->total 	= $row->total;

			$this->db->select('c.congressman_id as id, c.congressman_id, c.photo, a.attendance_state_id, c.names, c.last_names')
				->from('congressman c')
				->join('attendance a', 'c.congressman_id=a.congressman_id AND a.congress_session_id=' . intval($congress_session_id), 'left')
				->where('a.congressman_id IS NULL')
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
	 * Deletes a congressman from the attendance list
	 *
	 * @param	int			Law ID
	 * @param	int			Congressman ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function delete_attendance($congress_session_id, $congressman_id)
	{
		$where = array('congress_session_id' => $congress_session_id,
			'congressman_id' => $congressman_id);
		
		$this->db->delete('attendance', $where);

        return ($this->db->_error_number() == 0);
	}	

	/**
	 * Deletes all congressmen from the attendance list
	 *
	 * @param	int			Law ID
	 * @return	bool		TRUE if successful, FALSE otherwise
	 */		
	function delete_all($congress_session_id)
	{
		$where = array('congress_session_id' => $congress_session_id);
		
		$this->db->delete('attendance', $where);

        return ($this->db->_error_number() == 0);
	}	
}