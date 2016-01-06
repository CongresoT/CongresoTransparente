<?php
/**
  * roles management controller
  *
  * This is the roles management controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Role extends MY_Controller {	
	/**
	 *	property public
	 *	@access	modules_access	Stores role's roles/modules access for later processing;
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
		$this->module_name	= 'role';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Roles';
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
		$this->load->model('role_model', 'role_model');
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
			
		$this->grocery_crud->set_table('role');
		$this->grocery_crud->display_as('name','Nombre');
		$this->grocery_crud->display_as('active','Activo');
		$this->grocery_crud->display_as('modules_access','Accesos');
		$this->grocery_crud->set_subject('Usuario');
		
		$this->grocery_crud->change_field_type('active', 'true_false');
		
		// Validation rules
		
		$this->grocery_crud->set_rules('name','Nombre','required');	
		switch ($operation)
		{
			case 'edit':
				$this->grocery_crud->fields('name', 'active', 'modules_access');
				$this->grocery_crud->required_fields('name', 'active');
			break;
			case 'add':
				$this->grocery_crud->fields('name', 'active', 'modules_access');
				$this->grocery_crud->required_fields('name', 'active');
			break;
			case 'view':
				$this->grocery_crud->fields('name', 'active', 'modules_access');
			break;
		}
		
	
		$this->grocery_crud->columns('name', 'active');
				
		// BEGIN: Callbacks
		$this->grocery_crud->callback_before_insert(array($this, 'before_insert_role'));
		$this->grocery_crud->callback_before_update(array($this, 'before_update_role'));
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert_role'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update_role'));
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete_role'));
		$this->grocery_crud->callback_field('modules_access',array($this,'callback_modules_access'));		
		// END: Callbacks		
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/user_management.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('screen',$this->data_parts);
	}
	
	/**
	 * Action before inserting a role
	 *
	 * @param	array		Post data sent by browser
	 * @return	array		Post data
	 */

	function before_insert_role($data)
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
	 * Action before updating a role
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			role ID
	 * @return	array		Post data
	 */

	function before_update_role($data, $id)
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
	 * Action after inserting a role
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			role ID
	 * @return	array		Post data
	 */

	function after_insert_role($data, $id)
	{
		$this->role_model->insert_modules_access($id, $this->modules_access);
		
		if ($data['photo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/roles/' . $data['photo'];
			$config['thumb_marker'] = '_thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 35;
			$config['height']	= 40;

			$this->load->library('image_lib', $config); 

			$this->image_lib->resize();
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/admin/roles/' . $data['photo'];
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
	 * Action after updating a role
	 *
	 * @param	array		Post data sent by browser
	 * @param	int			role ID
	 * @return	none
	 */

	function after_update_role($data, $id)
	{
		$this->role_model->insert_modules_access($id, $this->modules_access);
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el rol con ID ' . $id . '.');
	}

	/**
	 * Custom modules access field
	 *
	 * @param	mixed			Field value
	 * @param	mixed			Primary key
	 * @return	none
	 */

	function callback_modules_access($value = null, $primary_key = null)
	{	
		$options	= $this->role_model->get_access_modules($primary_key);

		$output = '<select name="modules_access[]" multiple="multiple">';
		$close_group 	= FALSE;
		if (is_array($options))
		{
			foreach ($options as $option)
			{
				if ($option->parent > 1)
					$output .= '<option value="' . $option->module_id . '"' . ($option->access == 1 ? ' selected="selected"' : '') . '>' . $option->name . '</option>';
				else
				{
					if ($close_group)
					{
						$output .= '</optgroup>';
					}
					$output .= '<optgroup label="' . $option->name . '">';
					$close_group	= TRUE;
				}

			}
			if ($close_group)
			{
				$output .= '</optgroup>';
			}
			$close_group	= FALSE;
		}
		$output .= '</select>';
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
	public function after_delete_role($primary_key)
	{
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el rol con ID ' . $primary_key . '.');
	}	
}