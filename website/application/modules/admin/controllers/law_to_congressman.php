<?php
/**
  * Law to congressman controller
  *
  * This is the law to congressman controller for the administrator console.
  *
  * @package	Admin/Main/Controllers
  */
class Law_to_congressman extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct();
		$this->layout->set_template('admin');	
		
		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'law';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Diputado';
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
			redirect('/admin/login');
			
		if (!$this->authentication->has_access($this->session->get_user_id(), $this->module_name, USER_TYPE_ADMIN))
			redirect('/admin/no_access');
			
		$operation 		= $this->grocery_crud->getState();
		$state_info 	= $this->grocery_crud->getStateInfo();

		$template 		= $this->uri->segment(6);
		$single 		= $this->uri->segment(7);
		$law_id 	= $this->uri->segment(8);

		if ($template != '')
			$this->layout->set_template($template);
		
		$this->data_parts['filters']['law_id']	= $this->input->post('law_id', TRUE);
			
		// BEGIN: Get administrator allowed operations
		$operations = $this->authentication->get_admin_operations($this->session->get_user_id(), $this->module_name);
			
		if (!$operations->add)
			$this->grocery_crud->unset_add();
		if (!$operations->edit)
			$this->grocery_crud->unset_edit();
		if (!$operations->delete)
			$this->grocery_crud->unset_delete();
		// END: Get administrator allowed operations
		
		$this->grocery_crud->set_table('law_to_congressman');
		$this->grocery_crud->set_subject('Diputado');
		
		$this->grocery_crud->display_as('law_id','Actividad legislativa');
		$this->grocery_crud->display_as('congressman_id','Diputado');
		
		$this->grocery_crud->change_field_type('law_id', 'hidden');
		
		$this->grocery_crud->set_primary_key('congressman_id');
		
		$this->grocery_crud->set_relation('congressman_id','congressman', '{names} - {last_names}');

		$this->grocery_crud->columns('congressman_id', 'position', 'order');
	
		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));		
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		$this->grocery_crud->callback_field('law_id', array($this, 'field_law_id'));
		// END: Callbacks
	
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('congressman_id','Diputado','required');
		$this->grocery_crud->required_fields('congressman_id');
		// END: Validation rules
		
		if ($this->data_parts['filters']['law_id'] != '')
			$this->grocery_crud->where('law_to_congressman.law_id >=', $this->data_parts['filters']['law_id']);

		// BEGIN: Conditionals
		if ($law_id != 0)
		{
			
			$this->grocery_crud->where('law_to_congressman.law_id', $law_id);	
		}
		// END: Validation rules					
			
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];

		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('screen', $this->data_parts);
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó el diputado con ID ' . $post_array['congressman_id'] . ' en la actividad legislativa con ID ' . $post_array['law_id'] . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el diputado con ID ' . $post_array['congressman_id'] . ' en la actividad legislativa con ID ' . $post_array['law_id'] . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el diputado con ID ' . $post_array['congressman_id'] . ' en la actividad legislativa con ID ' . $post_array['law_id'] . '.');
	}	
	
	/**
	 * Congressman ID column callback
	 *
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function field_law_id($value, $row)
	{
		$law_id 	= $this->uri->segment(8);
		return '<input type="hidden" id="field-law_id" name="law_id" value="' . $law_id . '" />';
	}	
}