<?php
/**
  * Session controller
  *
  * This is the main session controller for the Freequent site.
  *
  * @package	Public/Core/Controllers
  */
class MY_Session extends CI_Session {
/**
 * Properties for this controller.
 *
 */

/**
 * @property string $session_id Session ID
 */
    private $session_id;
/**
 * @property object $db Database object
 */
    private $db;
/**
 * @property object $userinfo Raw user data from database
 */
    private $userinfo;
/**
 * @property string $usertype User type
 */
    private $usertype;

/**
 * @property object $usercourses Raw user courses data from database
 */
    private $usercourses;

/**
  * Class constructor
  *
  * Loads some of the common libraries, helpers and models used on the class.
  *
  * @access	public
  * @param	array	Session parameters
  * @return	none
  */
    function  __construct($params = array()) {
        parent::__construct($params);
        $CI =& get_instance();
        $this->db = $CI->load->database('default', TRUE);
    }

/**
  * Update an existing session
  *
  * Updates an existing Code Igniter session.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function sess_update() {
       if ( !($this->CI->input->is_ajax_request()) ) {
			$CI =& get_instance();
			$this->db = $CI->load->database('default',TRUE);
			
			$old_session_id	= $this->userdata('session_id');
			$user_id	= FALSE;
			
			// Get user ID if logged in
			if ($this->is_authenticated())
				$user_id	= $this->get_user_id();
			
			parent::sess_update();
			// Updated associated session ID in the user's database entry but only if the user has not logged in elsewhere
			if ($user_id && ($old_session_id == $this->userinfo->session_id)) 
			{
				$user_table	= '';
				$user_field	= '';
				switch ($this->get_usertype())
				{
					case USER_TYPE_FRONT: 
            $this->db->update(
              'student',
              array('session_id' => $this->get_session_id()),
              array('moodle_id' => $user_id));
    				break;
					case USER_TYPE_ADMIN:
            $this->db->update(
                'administrator',
                array('session_id' => $this->get_session_id()),
                array('admin_id' => $user_id));
		  			break;	
					default:
				}
        // Update session ID for this request
        $this->userinfo->session_id = $this->get_session_id();
			}
		}
    }

/**
  * Get session ID
  *
  * Gets the ID of the current session.
  *
  * @access	public
  * @param	none
  * @return	string	Session ID
  */
    function get_session_id() {
        return $this->userdata('session_id');
    }

/**
  * Get user data
  *
  * Gets the user data.
  *
  * @access	public
  * @param	none
  * @return	object	User data
  */
    function get_user_info() {
		// Get data from database only if there's a user ID set and the data was not retrieved earlier
		if (($this->get_user_id() > 0) && ($this->userinfo == NULL))
		{
			switch ($this->get_usertype())
			{
				case USER_TYPE_FRONT: 

          $query = $this->db->query('SELECT (\'student\') AS type, s.session_id, s.name AS student_name, s.moodle_id AS id, s.institution_id, a.* FROM student AS s INNER JOIN avatar AS a ON s.avatar_id= a.avatar_id WHERE s.moodle_id = '.$this->get_user_id());
          $result   = $query->result();

					$this->userinfo = (($query->num_rows() > 0) ? $query->row() : FALSE);

				break;
				case USER_TYPE_ADMIN:
					$this->db->select('a.*')
						->from('administrator AS a')
						->where(array('admin_id'=>  $this->get_user_id()));
					$query	= $this->db->get();
					$this->userinfo = ($query->num_rows() > 0) ? $query->row() : FALSE;
				break;	
				default:
					$this->userinfo = NULL;
			}
		}
		
        return $this->userinfo;
    }

/**
  * Get user courses data
  *
  * Gets the user courses data.
  *
  * @access public
  * @param  none
  * @return object  User courses data
  */
    function get_user_courses() {
      /*
    // Get data from database only if there's a user ID set and the data was not retrieved earlier
    if (($this->get_user_id() > 0) && ($this->is_student()))
    {
      $this->usercourses = $this->db->select('student_to_course.completed, course.icon, course.name, course.course_id')
              ->from('course')
              ->join('student_to_course', 'student_to_course.course_id = course.course_id')
              ->where('student_to_course.student_id', $this->get_user_id())
              ->order_by('course.order', 'asc')->get()->result();
    }
    
        return $this->usercourses;
        */
        return fasle;
    }


/**
  * Set user ID
  *
  * Sets user ID
  *
  * @access	public
  * @param	none
  * @return	bool	TRUE if the user is a student user, FALSE otherwise
  */
    function set_user_id($id) {
        return $this->set_userdata('id', $id);
    }
	
/**
  * Get user ID
  *
  * Gets the user ID
  *
  * @access	public
  * @param	none
  * @return	int	User ID
  */
    function get_user_id() {
		return $this->userdata('id');
    }


/**
  * Is authenticated
  *
  * Check if the current user has logged in. A user can only log in in one machine at the time.
  *
  * @access	public
  * @param	none
  * @return	bool	TRUE if user is logged in, FALSE otherwise
  */
    function is_authenticated() {
		// Checks if there's user data to retrieve.
		$this->get_user_info();
		// The user is logged in if the ID is set, there's user information to retrieve and the generated session ID is the same as the session ID stored in the the user entry
		return (($this->get_user_id() > 0) && ($this->userinfo != NULL) && ($this->userinfo->session_id == $this->get_session_id()));
    }

/**
  * Get user type
  *
  * Gets user type.
  *
  * @access	public
  * @param	none
  * @return	string	Returns the user type
  */
    function get_usertype() {
        return $this->userdata('usertype');
    }

/**
  * Set user type
  *
  * Sets the user type 
  *
  * @access	public
  * @param	int		User type
  * @return	none
  */
    function set_usertype($usertype) {
        $this->set_userdata('usertype', $usertype);
    }
	
/**
  * Set user type (administrator)
  *
  * Sets the user type as an admin type.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function set_usertype_admin() {
        $this->set_userdata('usertype', USER_TYPE_ADMIN);
    }

/**
  * Set user type (student)
  *
  * Sets the user type as student type.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function set_usertype_student() {
        $this->usertype = USER_TYPE_FRONT;
        $this->set_userdata('usertype', USER_TYPE_FRONT);
    }
	
/**
  * Unset user type
  *
  * Unsets the user type.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function unset_usertype() {
        $this->set_userdata('usertype', FALSE);
    }

/**
  * Is admin
  *
  * Checks if the user type is an administrator
  *
  * @access	public
  * @param	none
  * @return	bool	TRUE if the user is an administrator, FALSE otherwise
  */
    function is_admin() {
        return $this->userdata('usertype') == USER_TYPE_ADMIN;
    }

/**
  * Is student user
  *
  * Checks if the user type is a student user
  *
  * @access	public
  * @param	none
  * @return	bool	TRUE if the user is a student user, FALSE otherwise
  */
    function is_student() {
        return $this->userdata('usertype') == USER_TYPE_FRONT;
    }

    function is_front_user() {
        return $this->userdata('usertype') == USER_TYPE_FRONT;
    }
}