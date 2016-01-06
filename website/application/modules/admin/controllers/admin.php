<?php
/**
  * Admin controller
  *
  * This is the main controller for the administrator console of the Freequent site.
  *
  * @package	Admin/Main/Controllers
  */
class Admin extends MY_Controller {	
/**
 * Constructor for this controller.
 *
 */
	function  __construct() {
		parent::__construct('admin');
		
		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'main';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Consola Administrativa';
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

		/*
		$this->data_parts['content'] = $this->grocery_crud->render();
		$this->data_parts['content']->js_files	= array_merge($this->data_parts['content']->js_files, array(site_url('assets/js/users_management.js')));
		
		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('main/header', $this->data_parts);		
		if ($this->access_auth->has_access($this->data_parts['id_user'], $this->module_name)) {
			$this->load->view('main',$this->data_parts);
		} else
		{
			$this->load->view('main/no_access');
		}
		$this->load->view('main/footer');*/

		$this->load->view('home');		
	}

/**
  * Login form
  *
  * Login form.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function login() {
		if ($this->session->is_authenticated() && $this->session->is_admin())
			redirect('/admin');	
	
		$this->add_js_startup('
			$( "#admin-login-btn" ).click(function() {
				$( "#admin-login" ).submit();
			});

			$( "#reinit-pw-btn" ).click(function() {
				if ($("#login").val() == "")
				{
					alert("Debe ingresar un correo electrónico para poder reiniciar su contraseña.");
				}
				else if (confirm("¿Está seguro de qué desea reiniciar su contraseña? Se le enviará una nueva a su correo."))
				{
					$.ajax({
						type: "POST",
						dataType: "json",
						data: {email: $("#login").val()},
						url: "' . site_url('admin/reset_password') . '",
						success: function(data, textStatus, jq)
						{
							alert(data.message)
						}
					})
				}
			});
		');	
	
		$logged 		= FALSE;
		$submitted		= $this->input->post('submitted');
		$errors			= '';
		
		if ($submitted) 
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('login', 'Usuario', 'required');
			$this->form_validation->set_rules('password', 'Contraseña', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$errors	= validation_errors();
			}
			else
			{
				$userinfo		= $this->authentication->login($this->input->post('login'), $this->input->post('password'), USER_TYPE_ADMIN);
				if (!$userinfo) {
					$this->add_system_message('Usuario o contraseña inválidos.', SYS_MSG_STYLE_ERROR);
				} 
				else if ($userinfo->active != 1)
				{
					$this->add_system_message('Su usuario no ha sido activado. Revise su correo para ver instrucciones de cómo activar tu cuenta o contáctanos si tienes alguna duda.', SYS_MSG_STYLE_ERROR);
				} else {
					$logged	= TRUE;
					redirect('/admin');	
				}
			}
		}

		// Set title
		$this->data_parts['title'] = 'Iniciar Sesión';
		$this->set_title($this->data_parts['title']);
		
		$this->load->view('login', $this->data_parts);
    }
	
/**
  * Logout
  *
  * Logout action.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function logout() {
		$this->authentication->logout();
		redirect('admin');
    }	
	
/**
  * No access
  *
  * Shows a message telling the user has no access to the module.
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function no_access() {
		$this->add_system_message('No tienes acceso a este módulo.', SYS_MSG_STYLE_ERROR);
		$this->load->view('home', $this->data_parts);
    }
	
	public function reset_password() {
		$this->load->helper('json');
		$answer = array(
			'success' => FALSE,
			'message' => ''
		);
		
		$id = 0;
		
		$this->load->config('password');
		$this->load->helper('string');

		$email	= $this->input->post('email');
		
		$this->db->select('admin_id')
			->from('administrator')
			->where('email', $email);

		$query	= $this->db->get();
			
        if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$id = $row->admin_id;
			
			$new_pw			= random_string('alnum', 8);;
			$options		= array(
									'cost' => $this->config->item('password_cost'),
									'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
								);
			$hashed_password	= password_hash($new_pw, PASSWORD_BCRYPT, $options);

			$this->db->where('admin_id', $id);
			$this->db->update('administrator', array(
				'password' => $hashed_password
			));
			
			if ($this->db->_error_number() == 0)
			{
				$this->load->library('email');
				$this->load->config('email');
			
				$this->email->from($this->config->item('email_sender'), DEFAULT_SITE_TITLE);
				$this->email->to($email); 

				$this->email->subject('Reinicio de contraseña');
				$content	= 'Su contraseña ha sido reiniciada. Su nueva contraseña es <strong>' . $new_pw . '</strong> .';
				$html		= $this->load->view('mailing/base', array('content' => $content), TRUE);
				$this->email->message($html);	

				$this->email->send();		
			
				$answer['success'] = TRUE;
				$answer['message'] = 'Su contraseña ha sido reiniciada exitosamente. Se le ha enviado la nueva contaseña a su correo.';
			}			
		}
        else
		{
            $answer['success'] = FALSE;
			$answer['message'] = 'El correo que ingresó no es válido';
		}
			
		
		echo sendJson((object) $answer);
		exit();		
	}	
}