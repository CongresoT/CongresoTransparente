<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Political_party extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'political_party';
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
		
		$this->add_css_url('jPicker-1.1.6.min');
		$this->add_js_startup('
		$("#field-color").jPicker(
		{
		  	window:
		  	{
				expandable: true
  			},
			images:
			{
				clientPath: site_url + "/assets/images/"
			},
			localization: 
			{
				text:
				{
					title: "Arrastre el marcador para seleccionar un color",
					newColor: "nuevo",
					currentColor: "actual",
					ok: "Aceptar",
					cancel: "Cancelar"
				},
				tooltips:
				{
					colors:
					{
						newColor: \'Nuevo color - presione "Aceptar" para confirmar\',
						currentColor: "Presione para revertir al color original"
					},
					buttons:
					{
						ok: "Confirmar este color seleccionado",
						cancel: "Cancelar y revertir al color original"
					},
					hue:
					{
						radio: \'Fijar a modo de color "Hue"\',
						textbox: \'Ingrese un valor para "Hue" (0-360°)\' 
					},
					saturation:
					{
						radio: \'Fijar a modo de color "Saturation"\',
						textbox: \'Ingrese un valor para "Saturation" (0-360°)\' 
					},
					value:
					{
						radio: \'Fijar a modo de color "Value"\',
						textbox: \'Ingrese un valor para "Value" (0-360°)\' 
					},
					red:
					{
						radio: \'Fijar a modo de color "Red"\',
						textbox: \'Ingrese un valor para "Red" (0-360°)\' 
					},
					green:
					{
						radio: \'Fijar a modo de color "Green"\',
						textbox: \'Ingrese un valor para "Green" (0-360°)\' 
					},
					blue:
					{
						radio: \'Fijar a modo de color "Blue"\',
						textbox: \'Ingrese un valor para "Blue" (0-360°)\' 
					},
					alpha:
					{
						radio: \'Fijar a modo de color "Alpha"\',
						textbox: \'Ingrese un valor para "Alpha" (0-360°)\' 
					},
					hex:
					{
						radio: \'Fijar a modo de color "Hex"\',
						textbox: \'Ingrese un valor para "Hex" (0-360°)\' 
					}
				}	
			}	
		});');
		
		$this->grocery_crud->set_table('political_party');
		$this->grocery_crud->set_subject('Bancada');
		
		$this->grocery_crud->display_as('political_party_id','ID');
		$this->grocery_crud->display_as('full_name','Nombre');
		$this->grocery_crud->display_as('short_name','Nombre corto');
		$this->grocery_crud->display_as('logo','Miniatura');
		$this->grocery_crud->display_as('active','Activo');
		$this->grocery_crud->display_as('color','Color');

		$this->grocery_crud->set_field_upload('logo','assets/images/political_party');

		$this->grocery_crud->change_field_type('active', 'true_false');
		
		$this->grocery_crud->fields('full_name', 'short_name', 'logo', 'active', 'color');
		$this->grocery_crud->columns('full_name', 'short_name', 'logo', 'active', 'color');
		
		// BEGIN: Validation rules
		$this->grocery_crud->set_rules('full_name','Nombre','required');
		$this->grocery_crud->set_rules('short_name','Nombre corto','required');
		$this->grocery_crud->set_rules('active','Activo','required');
		$this->grocery_crud->required_fields('full_name', 'short_name', 'active');
		// END: Validation rules
		
		// BEGIN: Callbacks
		$this->grocery_crud->callback_after_insert(array($this, 'after_insert'));
		$this->grocery_crud->callback_after_update(array($this, 'after_update'));
		$this->grocery_crud->callback_after_delete(array($this, 'after_delete'));
		// END: Callbacks
		
		$this->data_parts['content'] 			= $this->grocery_crud->render();
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/jpicker-1.1.6.min.js')));		
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
		if ($post_array['logo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/political_party/' . $post_array['logo'];
			$config['new_image']	= 'assets/images/political_party/thumbnail/' . $post_array['logo'];
			$config['thumb_marker'] = '';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}	
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó la bancada ' . $post_array['full_name'] . ' con ID ' . $primary_key . '.');
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
		if ($post_array['logo'] != '')
		{
			// Generate two smaller images
			$config['image_library'] = 'gd2';
			$config['source_image']	= 'assets/images/political_party/' . $post_array['logo'];
			$config['new_image']	= 'assets/images/political_party/thumbnail/' . $post_array['logo'];
			$config['thumb_marker'] = '';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	 = 120;
			$config['height']	= 60;

			$this->load->library('image_lib', $config);
			
			$this->image_lib->resize();
		}			
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se actualizó la bancada con ID ' . $primary_key . '.');
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
		return $this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó la bancada con ID ' . $primary_key . '.');
	}
}