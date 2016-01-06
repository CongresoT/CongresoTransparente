<?php
/**
  * Users management controller
  *
  * This is the parameter controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Parameter extends MY_Controller {
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
		$this->module_name	= 'parameter';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Parámetros';
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
        $this->load->model('configuration_model');
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
		
		// BEGIN: Get administrator allowed operations
		$operations = $this->authentication->get_admin_operations($this->session->get_user_id(), $this->module_name);
/*
		if (!$operations->add)
			$this->grocery_crud->unset_add();
		if (!$operations->edit)
			$this->grocery_crud->unset_edit();
		if (!$operations->delete)
			$this->grocery_crud->unset_delete();
		// END: Get administrator allowed operations

		$operation = $this->uri->segment(4);
			
		$this->grocery_crud->set_table('parameter');
		$this->grocery_crud->display_as('description', 'Descripción');
		$this->grocery_crud->display_as('value','Valor');
		$this->grocery_crud->set_subject('Parámetros');
		
		switch ($operation)
		{
			case 'edit':
				$this->grocery_crud->fields('descrpition', 'value');
			break;
		}
		
		$this->grocery_crud->unset_add();
		$this->grocery_crud->unset_delete();
		$this->grocery_crud->unset_read();
		
		$this->grocery_crud->columns('description', 'value');

		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));		
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		// END: Callbacks
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/ui.dropdownchecklist-1.4-min.js'), site_url('assets/js/users_management.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('screen',$this->data_parts);

*/
		$this->add_js_url('parameter_configuration');

		$this->data_parts['table'] = $this->configuration_model->get();
		$this->data_parts['content']  = (object)array(
				'output' => $this->load->view('parameter_list',$this->data_parts, true) 
			);
		$this->load->view('screen',$this->data_parts);
	}

	/**
	 * Saving parameter function
	 *
	 * Saving parameter function
	 *
	 * @param	string	Primary Key
	 * @param	string	New value
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function save()
	{
		$key = $this->input->post('key');
		$value = $this->input->post('value');
		$type = $this->input->post('type');
		$validated = true;
		switch($type)
		{
			case 'int':
				$validated = (string)(int)$value == $value;
				break;
			case 'string':
				//$validated = $value != '';
				break;
			case 'email':
				//$validated = $value != '';
				break;
		}
		if ($validated)
		{
			$results= (object)array(
					'success' => $this->configuration_model->set($key, $value)
					);
			$this->after_update(array('key' => $key, 'value' => $value), $key);
		}
		else 
			$results= (object)array(
					'success' => false
					);

		echo json_encode($results);
		die;
	}

	
	/**
	 * After insert callback
	 *
	 * Action after inserting a record.
	 *
	 * @param	array	Inserted data
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function after_insert($post_array, $primary_key)
	{
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó el parámetro ' . $primary_key . '.');
	}
	
	/**
	 * After update callback
	 *
	 * Action after updating a record.
	 *
	 * @param	array	Inserted data
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */	
	function after_update($post_array, $primary_key)
	{
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el parámetro ' . $primary_key . '.');
	}	

	/**
	 * After delete callback
	 *
	 * Action after deleting a record.
	 *
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function after_delete($primary_key)
	{
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el parámetro ' . $primary_key . '.');
	}	
}