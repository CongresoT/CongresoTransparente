<?php
/**
  * Congressman to political party controller
  *
  * This is the congressman to political party controller for the administrator console.
  *
  * @package	Admin/Main/Controllers
  */
class Congressman_to_political_party extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct();
		$this->layout->set_template('admin');	
		
		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'congressman';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Bancadas';
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

		$template 			= $this->uri->segment(6);
		$single 			= $this->uri->segment(7);
		$congressman_id 	= $this->uri->segment(8);

		if ($template != '')
			$this->layout->set_template($template);
		
		$this->data_parts['filters']['congressman_id']	= $this->input->post('congressman_id', TRUE);
			
		// BEGIN: Get administrator allowed operations
		$operations = $this->authentication->get_admin_operations($this->session->get_user_id(), $this->module_name);
			
		if (!$operations->add)
			$this->grocery_crud->unset_add();
		if (!$operations->edit)
			$this->grocery_crud->unset_edit();
		if (!$operations->delete)
			$this->grocery_crud->unset_delete();
		// END: Get administrator allowed operations
		
		$this->grocery_crud->set_table('congressman_to_political_party');
		$this->grocery_crud->set_subject('Bancada');
		
		$this->grocery_crud->display_as('congressman_id','Diputado');
		$this->grocery_crud->display_as('political_party_id','Bancada');
		$this->grocery_crud->display_as('date_begin','Fecha de inicio');
		$this->grocery_crud->display_as('date_end','Fecha final');
		
		$this->grocery_crud->change_field_type('congressman_id', 'hidden');
		
		$this->grocery_crud->set_primary_key('political_party_id');
		
		$this->grocery_crud->set_relation('political_party_id','political_party', '{full_name} - {short_name}');

		$this->grocery_crud->columns('political_party_id', 'date_begin', 'date_end');
	
		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));		
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		$this->grocery_crud->callback_field('congressman_id', array($this, 'field_congressman_id'));
		// END: Callbacks
	
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('political_party_id','Bancada','required');
		$this->grocery_crud->set_rules('date_begin','Fecha de inicio','required');
		$this->grocery_crud->required_fields('political_party_id', 'date_begin');
		// END: Validation rules
		
		if ($this->data_parts['filters']['congressman_id'] != '')
			$this->grocery_crud->where('congressman_to_political_party.congressman_id >=', $this->data_parts['filters']['congressman_id']);

		// BEGIN: Conditionals
		if ($congressman_id != 0)
		{
			
			$this->grocery_crud->where('congressman_to_political_party.congressman_id', $congressman_id);	
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la bancada con ID ' . $post_array['political_party_id'] . ' en el historial del diputado con ID ' . $post_array['congressman_id'] . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó la bancada con ID ' . $post_array['political_party_id'] . ' en el historial del diputado con ID ' . $post_array['congressman_id'] . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó la bancada con ID ' . $post_array['political_party_id'] . ' en el historial del diputado con ID ' . $post_array['congressman_id'] . '.');
	}	
	
	/**
	 * Congressman ID column callback
	 *
	 * @param	int		Primary Key
	 * @return	bool	TRUE if successful, FALSE otherwise
	 */
	public function field_congressman_id($value, $row)
	{
		$congressman_id 	= $this->uri->segment(8);
		return '<input type="hidden" id="field-congressman_id" name="congressman_id" value="' . $congressman_id . '" />';
	}	
}