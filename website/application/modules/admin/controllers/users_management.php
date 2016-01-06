<?php
/**
  * Users management controller
  *
  * This is the users management controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Users_management extends MY_Controller {	
	/**
	 *	property public
	 *	@access	modules_access	Stores user's roles/modules access for later processing;
	 *
	 */
	public $modules_access;
	/**
	 * Constructor for this controller.
	 *
	 */
	function  __construct() {
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'users_management';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Usuarios';
		$this->set_title($this->data_parts['title']);
		// END: Set title
		
		// BEGIN: Load libraries
		$this->load->library('grocery_CRUD');
		// END: Load libraries

		// BEGIN: Load helpers
		$this->load->helper('language');
		// END: Load helpers

		// BEGIN: Load css
		$this->add_css_url('admin');
		// END: Load css

		// BEGIN: Load models
        $this->load->model('admin_model','admin_model',TRUE);
		$this->load->model('users_management_model', 'users_management_model');
		// END: Load models
	}
	
	/**
	 * Main function for the controller
	 *
	 * @param	none
	 * @return	none
	 */
	public function index() {
		if (!$this->session->is_authenticated() || !$this->session->is_admin())
			redirect('/admin/login');
			
		if (!$this->authentication->has_access($this->session->get_user_id(), $this->module_name, USER_TYPE_ADMIN))
			redirect('/admin/no_access');

		$operation 		= $this->grocery_crud->getState();
		$state_info 	= $this->grocery_crud->getStateInfo();
		$admin_id 	= 0;
		
		if (property_exists($state_info, 'primary_key'))
		{
			$admin_id 	= $state_info->primary_key;
		}
			
		$this->grocery_crud->set_table('administrator');
		$this->grocery_crud->display_as('name','Nombre');
		$this->grocery_crud->display_as('last_name','Apellido');
		$this->grocery_crud->display_as('email','Correo Electrónico');
		$this->grocery_crud->display_as('active','Activo');
		$this->grocery_crud->display_as('last_ip','Última IP');
		$this->grocery_crud->display_as('last_login','Última sesión');
		$this->grocery_crud->display_as('creation_date','Fecha creación');
		$this->grocery_crud->display_as('modification_date','Fecha modificación');
		$this->grocery_crud->display_as('password','Contraseña');
		$this->grocery_crud->display_as('password_confirm','Confirmar contraseña');
		$this->grocery_crud->display_as('role_id','Rol');
		$this->grocery_crud->display_as('photo','Fotografía');
		$this->grocery_crud->set_subject('Usuario');
		
		$this->grocery_crud->change_field_type('password', 'password', '');
		$this->grocery_crud->change_field_type('active', 'true_false');
		$this->grocery_crud->set_field_upload('photo','assets/images/admin/users');
		
		$this->grocery_crud->set_relation_n_n('role_id', 'administrator_to_role', 'role', 'admin_id', 'role_id', '{name}');
		
		// Validation rules
		
		$this->grocery_crud->set_rules('name','Nombre','required');	
		$this->grocery_crud->set_rules('last_name','Apellido','required');	
		switch ($operation)
		{
			case 'edit':
				$this->grocery_crud->set_rules('password','Contraseña','matches[password_confirm]');
				$this->grocery_crud->set_rules('password_confirm','Contraseña','');
				$this->grocery_crud->change_field_type('creation_date', 'hidden');
				$this->grocery_crud->change_field_type('modification_date', 'hidden');
				$this->grocery_crud->change_field_type('last_ip', 'hidden');			
				$this->grocery_crud->change_field_type('session_ip', 'hidden');
				$this->grocery_crud->fields('name', 'last_name', 'email', 'active', 'password', 'password_confirm', 'modification_date', 'photo', 'role_id');
				$this->grocery_crud->required_fields('email', 'name', 'last_name', 'active');
			break;
			case 'add':
				$this->grocery_crud->set_rules('password','Contraseña','required|matches[password_confirm]');
				$this->grocery_crud->set_rules('password_confirm','Confirmar contraseña','required');
				$this->grocery_crud->change_field_type('creation_date', 'hidden');
				$this->grocery_crud->change_field_type('modification_date', 'hidden');
				$this->grocery_crud->change_field_type('last_ip', 'hidden');
				$this->grocery_crud->change_field_type('session_ip', 'hidden');
				$this->grocery_crud->fields('name', 'last_name', 'email', 'active', 'password', 'password_confirm', 'last_ip', 'creation_date', 'modification_date', 'photo', 'role_id');
				$this->grocery_crud->required_fields('email', 'name', 'last_name', 'active', 'password', 'password_confirm');
			break;
			case 'view':
				$this->grocery_crud->set_rules('password','Contraseña','required|matches[password_confirm]');
				$this->grocery_crud->set_rules('password_confirm','Confirmar contraseña','required');
				$this->grocery_crud->change_field_type('creation_date', 'hidden');
				$this->grocery_crud->change_field_type('last_ip', 'hidden');
				$this->grocery_crud->change_field_type('session_ip', 'hidden');
				$this->grocery_crud->fields('name', 'last_name', 'email', 'active', 'last_ip', 'creation_date', 'modification_date', 'photo', 'role_id');
			break;
		}
		
		$this->grocery_crud->set_rules('email','Correo electrónico','required|valid_email|callback_check_email[' . $admin_id . ']');
		
		$this->grocery_crud->columns('name', 'last_name', 'email', 'role_id', 'active', 'photo', 'last_ip', 'last_login', 'creation_date', 'modification_date');
				
		// BEGIN: Callbacks
		$this->grocery_crud->callback_column('last_ip',array($this,'column_last_ip'));
		$this->grocery_crud->callback_before_insert(array($this, 'before_insert_user'));
		$this->grocery_crud->callback_before_update(array($this, 'before_update_user'));
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert_user'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update_user'));
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete_user'));
		$this->grocery_crud->callback_field('password',array($this,'callback_password'));
		$this->grocery_crud->callback_field('password_confirm',array($this,'callback_confirm_password'));
		// END: Callbacks		
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/users_management.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('screen',$this->data_parts);
	}
	
	/**
	 * Action before inserting a user
	 *
	 * @param	array		Post data sent by browser
	 * @return	array		Post data
	 */

	function before_insert_user($data)
	{
		$this->load->config('password');
		$options		= array(
								'cost' => $this->config->item('password_cost'),
								'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
							);
		$hashed_password	= password_hash($data['password'], PASSWORD_BCRYPT, $options);
		
		$data['password']			= $hashed_password;
		$data['last_ip']			= '';
		$data['creation_date']		= date('Y-m-d H:i:s');
		$data['modification_date']	= date('Y-m-d H:i:s');
		$this->modules_access	= unserialize(serialize($data['modules_access']));
		unset($data['modules_access']);
		unset($data['password_confirm']);
		return $data;
	}

	/**
	 * Action before updating a user
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			User ID
	 * @return	array		Post data
	 */

	function before_update_user($data, $id)
	{
		if (!empty($data['password']))
		{
			$this->load->config('password');
			$options		= array(
									'cost' => $this->config->item('password_cost'),
									'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
								);
			$hashed_password	= password_hash($data['password'], PASSWORD_BCRYPT, $options);

			$data['password']		= $hashed_password;
		}
		else
			unset($data['password']);
		$data['modification_date']		= date('Y-m-d H:i:s');
		$this->modules_access	= unserialize(serialize($data['modules_access']));
		unset($data['modules_access']);
		unset($data['password_confirm']);
		return $data;
	}

	/**
	 * Action after inserting a user
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			User ID
	 * @return	array		Post data
	 */

	function after_insert_user($data, $id)
	{
		if ($data['photo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/users/' . $data['photo'];
			$config['thumb_marker'] = '_thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 35;
			$config['height']	= 40;

			$this->load->library('image_lib', $config); 

			$this->image_lib->resize();
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/users/' . $data['photo'];
			$config['thumb_marker'] = '_small';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 100;			
			
			$this->image_lib->initialize($config);
			
			$this->image_lib->resize();
		}
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó el usuario ' . $data['name'] . ' ' . $data['last_name'] . ' con ID ' . $id . '.');
	}

	/**
	 * Action after updating a user
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			User ID
	 * @return	none
	 */

	function after_update_user($data, $id)
	{
		if ($data['photo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/users/' . $data['photo'];
			$config['thumb_marker'] = '_thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 35;
			$config['height']	= 40;

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/users/' . $data['photo'];
			$config['thumb_marker'] = '_small';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 100;			
			
			$this->image_lib->initialize($config);
			
			$this->image_lib->resize();
		}		
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el usuario con ID ' . $id . '.');
	}

	/**
	 * Custom password field
	 *
	 * @param	mixed			Field value
	 * @param	mixed			Primary key
	 * @return	none
	 */

	function callback_password($value = null, $primary_key = null)
	{
		$output = '<input name="password" type="password" value="" maxlength="255" />';
		return $output;
	}

	/**
	 * Custom confirm password field
	 *
	 * @param	mixed			Field value
	 * @param	mixed			Primary key
	 * @return	none
	 */

	function callback_confirm_password($value = null, $primary_key = null)
	{
		$output = '<input name="password_confirm" type="password" value="" maxlength="255" />';
		return $output;
	}

	/**
	 * After delete callback
	 *
	 * Action after deleting a record.
	 *
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function after_delete_user($primary_key)
	{
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el usuario con ID ' . $primary_key . '.');
	}	
	
	/**
	 * Last IP column render
	 *
	 * @param	mixed			value
	 * @param	mixed			Row
	 * @return	none
	 */

	function column_last_ip($value, $row)
	{	
		return long2ip($value);
	}		

	/**
	 * E-mail available validation
	 *
	 * @param	string	E-mail
	 * @param	int		Admin ID
	 * @return	none
	 */

	function check_email($email, $id)
	{	
		if ($this->users_management_model->is_email_available($email, $id))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_email','El correo electrónico ya fue asignado a un usuario administrador.');
			return FALSE;
		}
	}		
}