<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Content extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'content';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Contenidos';
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
			
		$this->grocery_crud->set_table('content');
		$this->grocery_crud->set_subject('Contenido');
		
		$this->grocery_crud->display_as('content_id','ID');
		$this->grocery_crud->display_as('title','Título');
		$this->grocery_crud->display_as('url_title','URL');
		$this->grocery_crud->display_as('content','Contenido');
		$this->grocery_crud->display_as('thumbnail','Miniatura');
		$this->grocery_crud->display_as('hits','Hits');
		$this->grocery_crud->display_as('creation_date','Fecha de creación');
		$this->grocery_crud->display_as('creation_admin_id','Usuario creación');
		$this->grocery_crud->display_as('modification_date','Fecha de modificación');
		$this->grocery_crud->display_as('modification_admin_id','Usuario modificación');

		$this->grocery_crud->set_field_upload('thumbnail','assets/images/content/thumbnail');
		
		$this->grocery_crud->set_relation('creation_admin_id', 'administrator', '{name} {last_name}');
		$this->grocery_crud->set_relation('modification_admin_id', 'administrator', '{name} {last_name}');

		$this->grocery_crud->change_field_type('active', 'true_false');
		
		$this->grocery_crud->fields('title', 'content', 'thumbnail');
		$this->grocery_crud->columns('title', 'content', 'thumbnail', 'hits', 'creation_date', 'modification_date', 'creation_admin_id', 'modification_admin_id');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('title','Título','required');
		$this->grocery_crud->set_rules('content','Contenido','required');
		$this->grocery_crud->required_fields('title', 'content', 'langauge_id', 'content_category_id');
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
		if ($post_array['thumbnail'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/content/thumbnail/' . $post_array['thumbnail'];
			$config['thumb_marker'] = '_thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}	
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó el contenido ' . $post_array['title'] . ' con ID ' . $primary_key . '.');
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
		if ($post_array['thumbnail'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/content/thumbnail/' . $post_array['thumbnail'];
			$config['thumb_marker'] = '_thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}			
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el contenido con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el contenido con ID ' . $primary_key . '.');
	}
}