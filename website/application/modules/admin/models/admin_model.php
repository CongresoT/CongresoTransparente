<?php
/**
  * Admin model
  *
  * This is the main admin model for the Freequent site.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/Admin/Models
  */
class admin_model extends CI_Model {

/**
  * Class constructor
  *
  * Loads some of the common libraries and helpers used on the class.
  *
  * @param	none
  * @return	none
  */
    public function __construct() {
        parent::__construct();
    }

/**
  * Add an entry to the administrator log
  *
  * Adds an entry to the administrator log.
  *
  * @access	public
  * @param	int		Administrator ID
  * @param	string	Action description
  * @return	bool	TRUE if successful, FALSE otherwise
  */
    public function add_to_log($admin_id, $description) {
		$this->db->insert('administrator_log', array(
			'admin_id' => $admin_id,
			'description' => $description,
			'creation_date' => date('Y-m-d H:i:s')
		));

		return ($this->db->_error_number() == 0);
	}
}