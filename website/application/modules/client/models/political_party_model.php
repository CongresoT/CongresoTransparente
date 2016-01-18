<?php
/**
  * Political party model
  *
  * This is the main model for the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/PoliticalParty/Models
  */
class Political_party_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get political parties list
	 *
	 * @param	none
	 * @return	array		Political parties information
	 */		
	function get_list()
	{
		$this->db->select('pp.*')
			->from('political_party pp');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get active political parties list
	 *
	 * @param	none
	 * @return	array		Political parties information
	 */		
	function get_active_list()
	{
		$this->db->select('pp.*')
			->from('political_party pp')
			->where('pp.active', 1);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get a specific political party
	 *
	 * @param	int			Political party ID
	 * @return	array		Political party information
	 */		
	function get($political_party_id)
	{
		$this->db->select('pp.*')
			->from('political_party pp')
			->where('p.political_party_id', $political_party_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->row();
		}
        else
            return FALSE;
	}
}