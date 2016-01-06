<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Commission extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'commission';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Comisiones';
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

		$this->grocery_crud->set_table('commission');
		$this->grocery_crud->set_subject('Comisión');
		
		$this->grocery_crud->display_as('comission_id','ID');
		$this->grocery_crud->display_as('name','Título');
		$this->grocery_crud->display_as('date','Fecha');
		
		$this->grocery_crud->fields('name', 'date');
		$this->grocery_crud->columns('name', 'date');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('name','Nombre','required');
		$this->grocery_crud->set_rules('date','Fecha','required');
		$this->grocery_crud->required_fields('name');
		// END: Validation rules
		
		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		// END: Callbacks
		
		switch ($operation)
		{
			case 'edit':
			case 'read':
				if ($this->authentication->has_access($this->session->get_user_id(), 'commission', USER_TYPE_ADMIN)) {
					$congressman_id = $state_info->primary_key;

					$this->add_js_startup('$("#tabs").tabs();
						$("#tabs-2-btn").click(function() {
								var helpFrame = jQuery("#tabs-2 iframe");
								helpFrame.css("height", "0px")
								var innerDoc = (helpFrame.get(0).contentDocument) ? helpFrame.get(0).contentDocument : helpFrame.get(0).contentWindow.document;
								helpFrame.height(innerDoc.body.scrollHeight + 35);
							});
						$("#tabs-2 iframe").load(function() {
								var helpFrame = jQuery("#tabs-2 iframe");
								helpFrame.css("height", "0px")
								var innerDoc = (helpFrame.get(0).contentDocument) ? helpFrame.get(0).contentDocument : helpFrame.get(0).contentWindow.document;
								helpFrame.height(innerDoc.body.scrollHeight + 35);
						});							
					');
					$this->data_parts['tabs']	= array(
						array('id' => 'tabs-1',
								'title' => 'Comisión',
								'type' => 'gcrud',
								'content' => $this->grocery_crud->render()),
						array('id' => 'tabs-2',
								'title' => 'Diputados',
								'type' => 'url',
								'content' => site_url('admin/commission_to_congressman/index/none/0/blank/1/' . $congressman_id)),
					);
					$this->data_parts['tabs'][0]['content']->js_files	= array_merge($this->data_parts['tabs'][0]['content']->js_files, array(site_url('assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js')));
					$this->grocery_crud_content				= $this->data_parts['tabs'][0]['content'];
				} else
				{
					$this->data_parts['content'] 			= $this->grocery_crud->render();
					$this->grocery_crud_content				= $this->data_parts['content'];				
				}
			break;
			default:
				$this->data_parts['content'] 			= $this->grocery_crud->render();
				$this->grocery_crud_content				= $this->data_parts['content'];
		}		
		
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la comisión ' . $post_array['name'] . ' con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó la comisión con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó la comisión con ID ' . $primary_key . '.');
	}
}