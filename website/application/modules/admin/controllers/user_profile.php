<?php
/**
  * User profile controller
  *
  * This is the users profile controller for the administrator console of the Freequent site.
  *
  * @package	Admin/Main/Controllers
  */
class User_profile extends MY_Controller {	
	/**
	 * Constructor for this controller.
	 *
	 */
	function  __construct() {
		parent::__construct('admin');
		
		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'user_profile';
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
			redirect('admin/login');

		$operation = $this->uri->segment(4);
		$id_user = $this->uri->segment(5);

		if ($this->session->get_user_id() != $id_user)
			redirect('admin');
			
		$this->grocery_crud->set_table('administrator');
		$this->grocery_crud->display_as('name','Nombre');
		$this->grocery_crud->display_as('last_name','Apellido');
		$this->grocery_crud->display_as('email','Correo Electrónico');
		$this->grocery_crud->display_as('password','Contraseña');
		$this->grocery_crud->display_as('password_confirm','Confirmar contraseña');
		$this->grocery_crud->display_as('photo','Fotografía');
		$this->grocery_crud->set_subject('Usuario');
		
		$this->grocery_crud->change_field_type('password', 'password', '');
		$this->grocery_crud->change_field_type('activated', 'true_false');
		$this->grocery_crud->set_field_upload('photo','assets/images/admin/users');
		
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
				$this->grocery_crud->fields('name', 'last_name', 'email', 'password', 'password_confirm', 'modification_date', 'photo');
			break;
			case 'view':
				$this->grocery_crud->set_rules('password','Contraseña','required|matches[password_confirm]');
				$this->grocery_crud->set_rules('password_confirm','Confirmar contraseña','required');
				$this->grocery_crud->change_field_type('creation_date', 'hidden');
				$this->grocery_crud->change_field_type('last_ip', 'hidden');
				$this->grocery_crud->fields('name', 'last_name', 'email', 'last_ip', 'creation_date', 'modification_date', 'photo');
			break;
			case 'success':
				$this->session->set_flashdata('message', 'Sus datos han sido actualizados.');
				redirect('admin');
			break;
		}
		
		$this->grocery_crud->set_rules('email','Correo electrónico','required|valid_email');
		$this->grocery_crud->required_fields('email', 'name', 'last_name', 'active');
		
		$this->grocery_crud->callback_before_update(array($this, 'before_update_user'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update_user'));
		$this->grocery_crud->callback_field('password',array($this,'callback_password'));
		$this->grocery_crud->callback_field('password_confirm',array($this,'callback_confirm_password'));
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/users_management.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		
		$this->load->view('screen',$this->data_parts);
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
		unset($data['password_confirm']);
		return $data;
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
			// Generate to smaller images
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
		
		return TRUE;
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
}