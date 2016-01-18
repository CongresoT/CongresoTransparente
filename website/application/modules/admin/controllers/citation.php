<?php
/**
  * Content controller
  *
  * This is the citation controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Citation extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'citation';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Citaciones';
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
			
		$operation 		= $this->grocery_crud->getState();
		$state_info 	= $this->grocery_crud->getStateInfo();

		$this->grocery_crud->set_table('citation');
		$this->grocery_crud->set_subject('Cita');
		
		$this->grocery_crud->display_as('citation_id','ID');
		$this->grocery_crud->display_as('citation_status_id','Estado');
		$this->grocery_crud->display_as('person_name','Persona');
		$this->grocery_crud->display_as('congressman_id','Diputado');
		$this->grocery_crud->display_as('location','Lugar');
		$this->grocery_crud->display_as('date','Fecha');
		$this->grocery_crud->display_as('subject','Asunto');
		$this->grocery_crud->display_as('description','Descripción');
		$this->grocery_crud->display_as('attachment','Archivo adjunto');
		$this->grocery_crud->display_as('audio','Audio');
		
		$this->grocery_crud->set_field_upload('attachment','assets/uploads/citation');
		$this->grocery_crud->set_field_upload('audio','assets/uploads/citation');

		$this->grocery_crud->fields('citation_status_id', 'congressman_id', 'person_name', 'location', 'date', 'subject', 'description', 'attachment', 'audio');
		$this->grocery_crud->columns('citation_status_id', 'congressman_id', 'person_name', 'location', 'date', 'subject');
		
		$this->grocery_crud->set_relation('citation_status_id', 'citation_status', '{name}');
		$this->grocery_crud->set_relation('congressman_id', 'congressman', '{names} - {last_names}');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('person_name','Persona','required');
		$this->grocery_crud->set_rules('citation_status_id','Estado','required');
		$this->grocery_crud->set_rules('location','Lugar','required');
		$this->grocery_crud->set_rules('date','Fecha','required');
		$this->grocery_crud->set_rules('subject','Asunto','required');
		$this->grocery_crud->required_fields('citation_status_id', 'person_name', 'location', 'date', 'subject');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la cita ' . $post_array['subject'] . ' con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó la cita con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó la cita con ID ' . $primary_key . '.');
	}
}