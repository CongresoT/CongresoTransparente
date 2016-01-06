<?php
/**
  * User management model
  *
  * This is the main model for user management on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/User_Management/Models
  */
class Users_management_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }
	
	/**
	 * Checks if the email address has not been already used
	 *
	 * @param	string 		E-mail
	 * @param	int 		ID
	 * @return	array		User modules information
	 */		
	function is_email_available($email, $id = 0)
	{
		$this->db->select('admin_id')
			->from('administrator')
			->where('email', $email)
			->where('admin_id !=', $id);
		$query	= $this->db->get();
			
        if ($query->num_rows() > 0)
		{
			return FALSE;
		}
        else
            return TRUE;
	}	
}