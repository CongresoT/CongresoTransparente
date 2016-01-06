<?php
/**
  * Configuration model
  *
  * This is the main model for configuration on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Configuration/Models
  */
class configuration_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }
	
	/**
	 * Gets user configuration information
	 *
	 * @param	none
	 * @return	array		Configuration data
	 */		
	function get()
	{
		$this->db->from('parameter')->order_by('key');
		$query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return 0;
	}

	function set($key, $value)
	{
		$this->db->where('key', $key)->update('parameter', array('value' => $value));

        if( $this->db->affected_rows() != 1)
            return false;
        else
            return true;   
	}

}