<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Attendance extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'attendance';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Asistencia';
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
		$this->load->model('attendance_model', 'attendance_model',TRUE);
		$this->load->model('congress_session_model', 'congress_session_model',TRUE);
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
			
		$congress_session_id = $this->input->post('congress_session_id', TRUE);
		$this->data_parts['congress_session_id'] = 0;
		$this->data_parts['default_congress_session_text'] = 'Seleccione una sesión';
		
		if (!$congress_session_id)
			$congress_session_id = $this->uri->segment(6);
		
		if ($congress_session_id)
		{
			$this->data_parts['congress_session_id'] = $congress_session_id;
			$congress_session_data 	= $this->congress_session_model->get_congress_session($congress_session_id);
			$attendances 		= $this->attendance_model->get_attendances($congress_session_id);

			if ($congress_session_data)
			{
				$this->data_parts['default_congress_session_text'] = $congress_session_data->name;
			}
			
			// Checks if there is attendances data available, if not, creates them
			if (!$attendances && intval($congress_session_id) > 0)
			{
				$eligible_congressmen = $this->attendance_model->get_eligible_congressmen($congress_session_id);
				if (!empty($eligible_congressmen) && is_array($eligible_congressmen))
					foreach ($eligible_congressmen as $congressman)
					{
						$this->attendance_model->insert_attendance($congress_session_id, $congressman->congressman_id, ATTENDANCE_STATE_ID_NONE);
					}
				$attendances = $this->attendance_model->get_attendances($congress_session_id);
			}

			$this->data_parts['congressmen'] = $attendances;
		}
		
		$this->add_css_url('select2');
		$this->add_js_url('select2');
		$this->add_js_url('es');
		$this->add_js_startup('
		$(".btn-attendance").tooltip();
		$("#btn-add-congressman").tooltip();
		$(".btn-delete-congressman").tooltip();
		
		// Change attendance action
		$(".btn-attendance").on("click", function() {
			if ($(this).hasClass("grayed"))
			{
				var congress_session_id = $("#congress_session_id").val();
				var attendance_state_id = $(this).attr("data-attendance_state_id");
				var congressman_id = $(this).parent().parent().attr("data-congressman_id");
				var current_btn = $(this);

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/change_attendance_result",
				  data: {
					congress_session_id: congress_session_id,
					attendance_state_id: attendance_state_id,
					congressman_id: congressman_id
				  },
				  dataType: "json",
				  method: "post"
				}).done(function(data) {
					if (data.success)
					{
						$("#window-error").html("");
						$("#window-error").css("display", "none");
						current_btn.parent().find(".btn-attendance").addClass("grayed");
						current_btn.removeClass("grayed");
					}
					else
					{
						$("#window-error").html(data.error_message);
						$("#window-error").show("display", "fast");
					}
				});
			}
		});
		
		// Delete attendance action
		$(".btn-delete-congressman").on("click", function() {
			if (confirm("Esto eliminará el voto seleccionado. ¿Está seguro?"))
			{
				var congress_session_id = $("#congress_session_id").val();
				var congressman_id = $(this).parent().parent().attr("data-congressman_id");
				var element = $(this);

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/delete_attendance",
				  data: {
					congress_session_id: congress_session_id,
					congressman_id: congressman_id
				  },
				  dataType: "json",
				  method: "post"
				}).done(function(data) {
					if (data.success)
					{
						$("#window-error").html("");
						$("#window-error").css("display", "none");
						element.parent().parent().remove();
					}
					else
					{
						$("#window-error").html(data.error_message);
						$("#window-error").show("display", "fast");
					}
				});
			}
		});

		// Delete all attendances action
		$("#btn-delete-congressmen").on("click", function() {
			if (confirm("Esto eliminará todos los voto ingresados en la inciativa seleccionada. ¿Está seguro?"))
			{			
				var congress_session_id = $("#congress_session_id").val();

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/delete_all_attendances",
				  data: {
					congress_session_id: congress_session_id
				  },
				  dataType: "json",
				  method: "post"
				}).done(function(data) {
					if (data.success)
					{
						$("#window-error").html("");
						$("#window-error").css("display", "none");
						$(".attendance-table-data").remove();
					}
					else
					{
						$("#window-error").html(data.error_message);
						$("#window-error").show("display", "fast");
					}
				});
			}
		});

		// Add congressman action
		$("#btn-add-congressman").on("click", function() {
			var congress_session_id = $("#congress_session_id").val();
			var congressman_id = $("#congressman_id").val();

			$.ajax({
			  url: site_url + "admin/' . $this->module_name . '/add_congressman",
			  data: {
				congress_session_id: congress_session_id,
				congressman_id: congressman_id
			  },
			  dataType: "json",
			  method: "post"
			}).done(function(data) {
				if (data.success)
				{
					$("#window-error").html("");
					$("#window-error").css("display", "none");
					$("#form-attendance").submit();
				}
				else
				{
					$("#window-error").html(data.error_message);
					$("#window-error").show("display", "fast");
				}
			});
		});
		
		// congress_sessions options
		var congress_session_select_options = {
		  language: \'es\',
		  id: function(congress_session) { return congress_session.congress_session_id; },
		  ajax: {
			url: site_url + "admin/' . $this->module_name . '/search_congress_sessions",
			dataType: \'json\',
			delay: 250,
			data: function (params) {
			  return {
				term: params.term,
				page: params.page
			  };
			},
			processResults: function (data, page) {
			  return {
				results: data.items
			  };
			},
			cache: true
		  },
		  minimumInputLength: 2,
		  templateResult: function (congress_session) {
		  if (congress_session.loading) return congress_session.text;

		  var markup = \'<div class="clearfix">\' +
			\'<div clas="col-sm-12">\' +
			  \'<div class="clearfix">\' +
		  \'<div class="col-sm-6"><strong>Fecha:</strong> \' + congress_session.name + \'</div>\' +
				\'<div class="col-sm-2"><strong>Estado:</strong> \' + congress_session.state + \'</div>\' +
			  \'</div>\';

		  markup += \'</div></div>\';

		  return markup;
		},
		  templateSelection: function (congress_session) {
			if (typeof(congress_session.name) != \'undefined\')
			{
				$(\'#congress_session_id\').val(congress_session.congress_session_id);
				
				$("#form-attendance").submit();
				
				return congress_session.name;
			}
			else
			{
				return $(\'#default_congress_session_text\').val();
			}
		  }
		};
		
		$("#congress_session-search").select2(congress_session_select_options);

		// Eligible congressmen options
		var congressman_select_options = {
		  language: \'es\',
		  ajax: {
			url: site_url + "admin/' . $this->module_name . '/search_eligible_congressmen",
			dataType: \'json\',
			delay: 250,
			data: function (params) {
			  return {
				term: params.term,
				page: params.page,
				congress_session_id: $(\'#congress_session_id\').val()
			  };
			},
			processResults: function (data, page) {
			  return {
				results: data.items
			  };
			},
			cache: true
		  },
		  minimumInputLength: 2,
		  templateResult: function (congressman) {
		  if (congressman.loading) return congressman.text;

		  var markup = \'<div class="clearfix">\' +
			\'<div class="col-sm-2">\' +
		  \'<img src="' . site_url('assets/images/congressman/thumbnail') . '/\' + (congressman.photo != "" ? congressman.photo : "default.png") + \'" style="max-width: 100%" />\' +
			\'</div>\' +
			\'<div clas="col-sm-10">\' +
			  \'<div class="clearfix">\' +
				\'<div class="col-sm-6">\' + congressman.last_names + \', \' + congressman.names + \'</div>\' +
			  \'</div>\';

		  markup += \'</div></div>\';

		  return markup;
		},
		  templateSelection: function (congressman) {
				$(\'#congressman_id\').val(congressman.congressman_id);
				if (typeof(congressman.names) != \'undefined\')
				{
					return congressman.last_names + \', \' + congressman.names;
				}
				else
				{
					return "Seleccione un diputado";
				}
		  }
		};
		
		$("#congressman-search").select2(congressman_select_options);');

		$this->data_parts['selected'] = $this->module_name;
		$this->load->view('attendance', $this->data_parts);
	}

	/**
	 * Change congressman attendance
	 *
	 * Changes congressman attendance
	 *
	 * @param	none
	 * @return	none
	 */
	public function change_attendance_result()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$congress_session_id			 	= intval($this->input->post('congress_session_id'));
		$attendance_state_id 	= intval($this->input->post('attendance_state_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($congress_session_id <= 0)
			$error_message = "Debe seleccionar una sesión.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->attendance_model->insert_attendance($congress_session_id, $congressman_id, $attendance_state_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó asistencia de diputado con ID ' . $congressman_id . ' sobre sesión con ID ' . $congress_session_id . '.');
			
			$error_message = $result ? '' : 'No se pudo cambiar asistencia.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}

	/**
	 * Add congressman
	 *
	 * Adds congressman to the attendance list
	 *
	 * @param	none
	 * @return	none
	 */
	public function add_congressman()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$congress_session_id			 	= intval($this->input->post('congress_session_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($congress_session_id <= 0)
			$error_message = "Debe seleccionar una sesión.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->attendance_model->insert_attendance($congress_session_id, $congressman_id,ATTENDANCE_STATE_ID_NONE);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se agregó sesión con ID ' . $congressman_id . ' al listado de votos sobre asistencia con ID ' . $congress_session_id . '.');
			
			$error_message = $result ? '' : 'No se pudo agregar diputado.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}

	/**
	 * Delete congressman
	 *
	 * Deletes congressman from attendance list
	 *
	 * @param	none
	 * @return	none
	 */
	public function delete_attendance()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$congress_session_id			 	= intval($this->input->post('congress_session_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($congress_session_id <= 0)
			$error_message = "Debe seleccionar una sesión.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->attendance_model->delete_attendance($congress_session_id, $congressman_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó asistencia de diputado con ID ' . $congressman_id . ' sobre sesión con ID ' . $congress_session_id . '.');
			
			$error_message = $result ? '' : 'No se pudo eliminar asistencia.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}
	
	/**
	 * Delete all congressmen
	 *
	 * Deletes all congressmen from attendance list
	 *
	 * @param	none
	 * @return	none
	 */
	public function delete_all_attendances()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$congress_session_id			 	= intval($this->input->post('congress_session_id'));

		if ($congress_session_id <= 0)
			$error_message = "Debe seleccionar una iniciativa.";
		
		if (!$error_message)
		{		
			$result = $this->attendance_model->delete_all($congress_session_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó votos de todos los diputados sobre iniciativa con ID ' . $congress_session_id . '.');
			
			$error_message = $result ? '' : 'No se pudo eliminar votos.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}

	/**
	 * Search list of eligible congressmen in JSON format
	 *
	 * @param	none
	 * @return	none
	 */
	function search_eligible_congressmen()
	{	
		$searchterm	= $this->input->get('term');
		$page		= $this->input->get('page');
		$congress_session_id		= $this->input->get('congress_session_id');
		$this->load->helper('json');
		
		$users 	= $this->attendance_model->search_eligible_congressmen($congress_session_id, $searchterm, $page);
		
		$data	= array('total_count' => $users->total,
						'items' => $users->congressmen);
	
        echo json_encode($data);
		die;
	}

	/**
	 * Search list of eligible congressmen in JSON format
	 *
	 * @param	none
	 * @return	none
	 */
	function search_congress_sessions()
	{	
		$searchterm	= $this->input->get('term');
		$page		= $this->input->get('page');
		$congress_session_id		= $this->input->get('congress_session_id');
		$this->load->helper('json');
		
		$users 	= $this->congress_session_model->search_congress_sessions($searchterm, $page);
		
		$data	= array('total_count' => $users->total,
						'items' => $users->congress_sessions);
	
        echo json_encode($data);
		die;
	}
}