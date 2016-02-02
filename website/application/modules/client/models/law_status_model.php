<?php
/**
  * Law status model
  *
  * This is the law status model for the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/LawStatus/Models
  */
class Law_status_model extends CI_Model {

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
	 * @return	array		Law status information
	 */		
	function get_list()
	{
		$this->db->select('ls.*, ls.law_status_id as law_status_id')
			->from('law_status ls')
			->order_by('ls.order');
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return FALSE;
	}
}