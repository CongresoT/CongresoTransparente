<?php
/**
  * Administrator log controller
  *
  * This is the administrator log controller for the administrator console of the Freequent site.
  *
  * @package	Admin/Main/Controllers
  */
class Admin_log extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'admin_log';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Bitácora';
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

		$this->data_parts['filters']['date_begin']	= $this->input->post('date_begin', TRUE);
		$this->data_parts['filters']['date_end']	= $this->input->post('date_end', TRUE);
			
		$this->grocery_crud->unset_add();
		$this->grocery_crud->unset_edit();
		$this->grocery_crud->unset_delete();
			
		$this->grocery_crud->set_table('administrator_log');
		$this->grocery_crud->set_subject('Bitácora');
		
		$this->grocery_crud->display_as('administrator_log_id','ID');
		$this->grocery_crud->display_as('admin_id','Usuario');
		$this->grocery_crud->display_as('description','Descripción');
		$this->grocery_crud->display_as('creation_date','Fecha');
		
		$this->grocery_crud->set_relation('admin_id','administrator', '{name} {last_name}');
		
		$this->grocery_crud->set_subject('Bitácora');
		
		$this->add_js_startup('$( "#date_begin" ).datepicker({
			  defaultDate: "+1w",
			  dateFormat: "yy-mm-dd",
			  changeMonth: true,
			  numberOfMonths: 1,
			  onClose: function( selectedDate ) {
				$( "#date_end" ).datepicker( "option", "minDate", selectedDate );
			  }
			});
			
			$( "#date_end" ).datepicker({
			  defaultDate: "+1w",
			  dateFormat: "yy-mm-dd",
			  changeMonth: true,
			  numberOfMonths: 1,
			  onClose: function( selectedDate ) {
				$( "#date_begin" ).datepicker( "option", "maxDate", selectedDate );
			  }
			});
		');
			
		if ($this->data_parts['filters']['date_begin'] != '')
			$this->grocery_crud->where('administrator_log.creation_date >=', $this->data_parts['filters']['date_begin']);

		if ($this->data_parts['filters']['date_end'] != '')
			$this->grocery_crud->where('administrator_log.creation_date <=', $this->data_parts['filters']['date_end']);
			
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->grocery_crud_content				= $this->data_parts['content'];
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/jquery.mtz.monthpicker.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('admin_log',$this->data_parts);
	}
}