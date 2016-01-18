<?php
/**
  * District model
  *
  * This is the main model for the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/District/Models
  */
class District_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get districts list
	 *
	 * @param	none
	 * @return	array		District list
	 */		
	function get_list()
	{
		$this->db->select('d.*')
			->from('district d');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}

	/**
	 * Get a specific district
	 *
	 * @param	int			District ID
	 * @return	array		District information
	 */		
	function get($district_id)
	{
		$this->db->select('d.*')
			->from('district d')
			->where('d.district_id', $district_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->row();
		}
        else
            return FALSE;
	}
}