<?php
/**
  * Content model
  *
  * This is the main model for content on the public part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Content/Models
  */
class Content_model extends CI_Model {

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
	 * @param	int			Content ID
	 * @return	array		Content information
	 */		
	function get($content_id)
	{
		$this->db->select('c.*')
			->from('content c')
			->where('c.content_id', $content_id);
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->row();
		}
        else
            return FALSE;
	}
}