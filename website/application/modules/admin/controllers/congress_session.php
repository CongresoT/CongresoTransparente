<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Congress_session extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'congress_session';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Sesiones';
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
        $this->load->model('admin_model', 'admin_model',TRUE);
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
			
		if (!$operations->add)
			$this->grocery_crud->unset_add();
		if (!$operations->edit)
			$this->grocery_crud->unset_edit();
		if (!$operations->delete)
			$this->grocery_crud->unset_delete();
		// END: Get administrator allowed operations
			
		$this->grocery_crud->set_table('congress_session');
		$this->grocery_crud->set_subject('Sesión');
		
		$this->grocery_crud->display_as('congress_session_id','ID');
		$this->grocery_crud->display_as('state_id','Estado');
		$this->grocery_crud->display_as('description_link','Vínculo');
		$this->grocery_crud->display_as('description','Descripción');
		$this->grocery_crud->display_as('date_begin','Fecha y hora de inicio');
		$this->grocery_crud->display_as('date_end','Fecha y hora de finalización');
		
		$this->grocery_crud->fields('state_id', 'date_begin', 'date_end', 'description_link', 'description');
		$this->grocery_crud->columns('state_id', 'date_begin', 'date_end');
		
		$this->grocery_crud->set_relation('state_id', 'congress_session_state', '{name}');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('state_id','Estado','required');
		$this->grocery_crud->set_rules('date_begin','Fecha y hora de inicio','required');
		$this->grocery_crud->set_rules('date_end','Fecha y hora de finalización','required');
		$this->grocery_crud->required_fields('name', 'date_begin', 'date_end');
		// END: Validation rules
		
		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		// END: Callbacks
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('screen',$this->data_parts);
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la sesión con ID ' . $primary_key . ' con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó la sesión con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó la sesión con ID ' . $primary_key . '.');
	}
}