<?php
/**
 * Authentication handling
 *
 * A Codeigniter library to handle user login and module access.
 *
 * Copyright (C) 2013  Donald Leiva.
 *
 * @package    	Authentication
 * @copyright  	Copyright (c) 2013, Donald Leiva
 * @version    	1.0.0
 * @author     	Donald Leiva <admin@donaldleiva.com>
 */
class authentication
{
/**
 * Properties for this controller.
 *
 */

/**
 * @property string $session Session library
 */
    private $session;
/**
 * @property object $db Database object
 */
    private $db;	
/**
  * Class constructor
  *
  * Loads everything needed for the library
  *
  * @param	array	Parameters
  * @return	none
  */
    function  __construct($parameters) {
		if (!empty($parameters['session']))
			$this->session	= $parameters['session'];
		else
			show_error('Unable to load session library on authentication library. Check that the object is being passed correctly.');
		$CI =& get_instance();
		$this->db 	= $CI->load->database('default', TRUE);
    }

	private function moodle_password_verify($password, $hash) {
	 if (!function_exists('crypt')) {
	     trigger_error("Crypt must be loaded for password_verify to function", E_USER_WARNING);
	     return false;
	 }
	 $ret = crypt($password, $hash);
	 if (!is_string($ret) || strlen($ret) != strlen($hash) || strlen($ret) <= 13) {
	     return false;
	 }

	 $status = 0;
	 for ($i = 0; $i < strlen($ret); $i++) {
	     $status |= (ord($ret[$i]) ^ ord($hash[$i]));
	 }

	 return $status === 0;
	}


	private function moodle_login($username, $password) {
		$CI 		= & get_instance();
		
		$moodle_conn	= 'mysql://' . $CI->parameters['moodle_db_user'] . ':' . $CI->parameters['moodle_db_password'] . '@' . $CI->parameters['moodle_db_host'] . ':' . $CI->parameters['moodle_db_port'] . '/' . $CI->parameters['moodle_db_name'];

	    $newdb = $CI->load->database($moodle_conn, true);
	    $newdb->select('*')
					->from('mdl_user')
					->where('username', $username);
		$query = $newdb->get();

	    if ($query->num_rows() > 0 )
	    {
			$userinfo		= $query->row();
			if ($this->moodle_password_verify($password, $userinfo->password))
				return $userinfo->id;
		}
		return 0;
	}

/**
  * Login
  *
  * Login a user
  *
  * @access	public
  * @param	string	Username
  * @param	string	Password (raw)
  * @param	int		User type (optional)
  * @return	object	User info
  */
    public function login($user, $password, $user_type = USER_TYPE_FRONT) {
		// Load password configuration
		$CI 		= & get_instance();
		$CI->load->config('password');
		$options		= array(
								'cost' => $CI->config->item('password_cost'),
								'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
							);

		$moodle_id = 0;
		// Search the user in the corresponding table according to type
		switch ($user_type)
		{
			// Administrator user login
			case USER_TYPE_ADMIN:
				$query = $this->db->select('a.admin_id as id, a.name, a.last_name, a.active, a.password')
					->from('administrator AS a')
					->where('a.email', $user)
					->where('a.active', 1)->get();
			break;
			default:
				return FALSE;
		}


		$userid = 0;
        if ($query->num_rows() > 0)
		{
			// Update session with user information
			switch ($user_type)
			{
				case USER_TYPE_ADMIN:
				$userinfo		= $query->row();

				// Administrator users store a salted hash, so verify this against the password
				if (!password_verify($password, $userinfo->password))
					return FALSE;
				// Updates last login IP and datetime
				$this->db->update(
						'administrator',
						array('last_ip' => sprintf("%u", ip2long($CI->input->ip_address())),
								'last_login' => date('Y-m-d H:i:s')),
						array('admin_id' => $userinfo->id));
						
				// BEGIN: Load models
				$CI =& get_instance();
				$CI->load->model('admin/admin_model','admin_model',TRUE);
				// END: Load models	

				$userid = $userinfo->id;
				$CI->admin_model->add_to_log($userinfo->id, $userinfo->name . ' ' . $userinfo->last_name . ' inició sesión.');
				break;
			}
			$this->session->set_usertype($user_type);
			$this->session->set_user_id($userid);
			$this->update_session_id($userid, $this->session->get_session_id(), $user_type);

			return $userinfo;
		}
        else
            return FALSE;
	}

/**
  * Logout
  *
  * Logout the current user
  *
  * @access	public
  * @param	none
  * @return	none
  */
    public function logout() {
		switch ($this->session->get_usertype())
		{
			// Student user login
			case USER_TYPE_FRONT:
			break;
			case USER_TYPE_ADMIN:					
			// BEGIN: Load models
			$CI =& get_instance();
			$CI->load->model('admin/admin_model','admin_model',TRUE);
			// END: Load models	
			
			$userinfo 	= $this->session->get_user_info();
			$CI->admin_model->add_to_log($this->session->get_user_id(), $userinfo->name . ' ' . $userinfo->last_name . ' finalizó sesión.');
			break;
		}

		$this->update_session_id($this->session->get_user_id(), '');
		$this->session->unset_usertype();
		$this->session->set_user_id(NULL);
	}

/**
  * Has access
  *
  * Checks if the user has access to a specific module
  *
  * @access	public
  * @param	int		User ID
  * @param	string	Module name
  * @param	int		User type
  * @return	bool	TRUE if successful, FALSE otherwise
  */
    public function has_access($user_id, $module_internal_name, $user_type = USER_TYPE_ADMIN) {
		if ($this->session->is_authenticated())
		{
			switch ($user_type)
			{
				// Administrator user access check
				case USER_TYPE_ADMIN:
					$this->db->select('DISTINCT m.module_id', FALSE)
						->from('administrator_module_access AS ma')
						->join('administrator_module AS m', 'm.module_id=ma.module_id', 'inner')
						->join('administrator_to_role AS ar', 'ar.role_id=ma.role_id', 'inner')
						->where('m.internal_name', $module_internal_name)
						->where('ar.admin_id', $user_id);
					$query = $this->db->get();

					return ($query->num_rows() > 0);
				break;
				default:
					return FALSE;
			}
		}
		return FALSE;
	}
	
	
/**
  * Get admin operations
  *
  * Get administrator operations
  *
  * @access	public
  * @param	int		User ID
  * @param	string	Module name
  * @return	object	Valid operations data
  */
    public function get_admin_operations($user_id, $module_internal_name) {
		$this->db->select('DISTINCT ma.add, ma.delete, ma.edit', FALSE)
			->from('administrator_module_access AS ma')
			->join('administrator_module AS m', 'm.module_id=ma.module_id', 'inner')
			->join('administrator_to_role AS ar', 'ar.role_id=ma.role_id', 'inner')
			->where('m.internal_name', $module_internal_name)
			->where('ar.admin_id', $user_id);
		$query = $this->db->get();

		return $query->row();
	}

/**
  * Update session ID
  *
  * Updates session ID.
  *
  * @access	public
  * @param	int	User ID
  * @param	string	Session ID
  * @param	int		User type (optional)
  * @return	none
  */
    function update_session_id($user_id, $session_id, $user_type = USER_TYPE_FRONT) {
		$user_table	= '';
		$user_field	= '';
		switch ($user_type)
		{
			// Administrator user session update
			case USER_TYPE_ADMIN:
		        $this->db->update(
		                'administrator',
		                array('session_id' => $session_id),
		                array('admin_id' => $user_id));
			break;
			default:
				return FALSE;
		}

		return TRUE;
    }
	
/**
  * Get menu
  *
  * Gets the admin menu
  *
  * @access	public
  * @param	int		User ID
  * @param	int		User type
  * @return	array	Array with menu elements
  */
    public function get_menu($user_id, $user_type = USER_TYPE_ADMIN) {
		if ($this->session->is_authenticated())
		{
			switch ($user_type)
			{
				// Regular user (student) access check
				case USER_TYPE_FRONT:
					return TRUE;
				break;
				// Administrator user access check
				case USER_TYPE_ADMIN:
					$this->db->select('DISTINCT mc.parent, m.module_id, m.internal_name, m.name, m.icon_class', FALSE)
						->from('administrator_module m')
						->join('administrator_module_closure as mc', 'm.module_id=mc.child AND mc.depth=1', 'inner')
						->join('administrator_module_access as ma', 'ma.module_id=m.module_id', 'inner')
						->join('administrator_to_role AS ar', 'ar.role_id=ma.role_id', 'inner')
						->where('ar.admin_id', $user_id)
						->order_by('m.order, mc.child, mc.parent, mc.depth');
					$query = $this->db->get();

					if ($query->num_rows() > 0)
						return $query->result();
					else
						return FALSE;
				break;
				default:
					return FALSE;
			}
		}
		return FALSE;
	}
}