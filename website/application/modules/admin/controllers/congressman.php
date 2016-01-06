<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Congressman extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'congressman';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Diputados';
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
			
		$this->grocery_crud->set_table('congressman');
		$this->grocery_crud->set_subject('Diputado');
		
		$this->grocery_crud->display_as('congressman_id','ID');
		$this->grocery_crud->display_as('district_id','Distrito');
		$this->grocery_crud->display_as('names','Nombres');
		$this->grocery_crud->display_as('last_names','Apellidos');
		$this->grocery_crud->display_as('birthday','Fecha de nacimiento');
		$this->grocery_crud->display_as('sex_id','Sexo');
		$this->grocery_crud->display_as('description','Descripción');
		$this->grocery_crud->display_as('curriculum','Currículum');
		$this->grocery_crud->display_as('photo','Fotografía');
		$this->grocery_crud->display_as('facebook_account','Cuenta de Facebook');
		$this->grocery_crud->display_as('twitter_account','Cuenta de Twitter');
		$this->grocery_crud->display_as('twitter_hashtag','Hashtag');
		$this->grocery_crud->display_as('numero_legislaturas','Número de legislaturas');

		$this->grocery_crud->set_field_upload('photo','assets/images/congressman');
		$this->grocery_crud->set_field_upload('curriculum','assets/uploads/congressman');

		$this->grocery_crud->change_field_type('active', 'true_false');
		$this->grocery_crud->change_field_type('numero_legislaturas', 'integer');
		
		$this->grocery_crud->fields('names', 'last_names', 'district_id', 'sex_id', 'birthday', 'description', 'photo', 'curriculum', 'facebook_account', 'twitter_account', 'twitter_hashtag', 'numero_legislaturas', 'active');
		$this->grocery_crud->columns('names', 'last_names', 'district_id', 'sex_id', 'birthday', 'photo', 'numero_legislaturas', 'active');
		
		$this->grocery_crud->set_relation('sex_id', 'sex', '{name}');
		$this->grocery_crud->set_relation('district_id', 'district', '{name}');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('names','Nombres','required');
		$this->grocery_crud->set_rules('last_names','Apellidos','required');
		$this->grocery_crud->set_rules('district_id','Distrito','required');
		$this->grocery_crud->set_rules('sex_id','Sexo','required');
		$this->grocery_crud->set_rules('birthday','Fecha de nacimiento','required');
		$this->grocery_crud->set_rules('active','Activo','required');
		$this->grocery_crud->required_fields('names', 'last_names', 'district_id', 'sex_id', 'birthday', 'active');
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
				if ($this->authentication->has_access($this->session->get_user_id(), 'congressman', USER_TYPE_ADMIN)) {
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
								'title' => 'Diputado',
								'type' => 'gcrud',
								'content' => $this->grocery_crud->render()),
						array('id' => 'tabs-2',
								'title' => 'Bancada',
								'type' => 'url',
								'content' => site_url('admin/congressman_to_political_party/index/none/0/blank/1/' . $congressman_id)),
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
		if ($post_array['photo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/congressman/' . $post_array['photo'];
			$config['new_image']	= 'assets/images/congressman/thumbnail/' . $post_array['photo'];
			$config['thumb_marker'] = '';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}	
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la bancada ' . $post_array['names'] . ' '. $post_array['last_names'] . ' con ID ' . $primary_key . '.');
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
		if ($post_array['photo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/congressman/' . $post_array['photo'];
			$config['new_image']	= 'assets/images/congressman/thumbnail/' . $post_array['photo'];
			$config['thumb_marker'] = '';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}			
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó el diputado con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó el diputado con ID ' . $primary_key . '.');
	}
}