<?php
/**
  * Law model
  *
  * This is the main model for laws on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Law/Models
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
	 * Get a specific law
	 *
	 * @param	int			Law ID
	 * @return	array		Congressmen information
	 */		
	function get_law($law_id)
	{
		$this->db->select('l.*, l.law_id as id')
			->from('law l')
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
	 * Searches laws
	 *
	 * @param	string		Search string
	 * @param	int			Page
	 * @return	array		Congressmen information
	 */		
	function search_laws($searchstring = "", $page = 0)
	{
		$this->db->select('COUNT(*) total')
			->from('law l');
			
		if ($searchstring != "")
			$this->db->where('(l.name LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR l.description LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR l.number LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');

        $query = $this->db->get();

		$data	= (object) array('total' => 0,
							'laws' => array());
		
        if ($query->num_rows() > 0)
		{
			$row 			= $query->row();
			$data->total 	= $row->total;

			$this->db->select('*, law_id as id')
				->from('law l');
				
			if ($searchstring != "")
				$this->db->where('(l.name LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR l.description LIKE "%' . $this->db->escape_like_str($searchstring) . '%" OR l.number LIKE "%' . $this->db->escape_like_str($searchstring) . '%")');

			$query	= $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				$data->laws = $query->result();
			}
		}
		
		return $data;
	}	
}