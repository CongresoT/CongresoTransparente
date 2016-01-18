<?php
/**
  * Law type model
  *
  * This is the law type model for the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/LawType/Models
  */
class Law_type_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }

	/**
	 * Get law type list
	 *
	 * @param	none
	 * @return	array		Law types information
	 */		
	function get_list()
	{
		$this->db->select('lt.*')
			->from('law_type lt');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}
}