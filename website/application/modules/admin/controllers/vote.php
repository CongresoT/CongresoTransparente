<?php
/**
  * Content controller
  *
  * This is the content controller for the administrator console of the site.
  *
  * @package	Admin/Main/Controllers
  */
class Vote extends MY_Controller {
	/**
	 * Constructor for this controller.
	 *
	 */
	 
	function  __construct() {		
		parent::__construct('admin');

		$this->modules_access	= null;
		
		// BEGIN: Set module name
		$this->module_name	= 'vote';
		// END: Set module name
		
		// BEGIN: Set title
		$this->data_parts['title'] = 'Votaciones';
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
		$this->load->model('vote_model', 'vote_model',TRUE);
		$this->load->model('law_model', 'law_model',TRUE);
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
			
		$law_id = $this->input->post('law_id', TRUE);
		$this->data_parts['law_id'] = 0;
		$this->data_parts['default_law_text'] = 'Seleccione una iniciativa';
		
		if (!$law_id)
			$law_id = $this->uri->segment(6);
		
		if ($law_id)
		{
			$this->data_parts['law_id'] = $law_id;
			$law_data 	= $this->law_model->get_law($law_id);
			$votes 		= $this->vote_model->get_votes($law_id);

			if ($law_data)
			{
				$this->data_parts['default_law_text'] = $law_data->name;
			}
			
			// Checks if there is votes data available, if not, creates them
			if (!$votes && intval($law_id) > 0)
			{
				$eligible_congressmen = $this->vote_model->get_eligible_congressmen($law_id);
				if (!empty($eligible_congressmen) && is_array($eligible_congressmen))
					foreach ($eligible_congressmen as $congressman)
					{
						$this->vote_model->insert_vote($law_id, $congressman->congressman_id, null, VOTE_RESULT_ID_NONE);
					}
				$votes = $this->vote_model->get_votes($law_id);
			}
			
			$this->data_parts['congressmen'] = $votes;
		}
		
		$this->add_css_url('select2');
		$this->add_js_url('select2');
		$this->add_js_url('es');
		$this->add_js_startup('
		$(".btn-vote").tooltip();
		$("#btn-add-congressman").tooltip();
		$(".btn-delete-congressman").tooltip();
		
		// Change vote action
		$(".btn-vote").on("click", function() {
			if ($(this).hasClass("grayed"))
			{
				var law_id = $("#law_id").val();
				var vote_result_id = $(this).attr("data-vote_result_id");
				var congressman_id = $(this).parent().parent().attr("data-congressman_id");
				var current_btn = $(this);

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/change_vote_result",
				  data: {
					law_id: law_id,
					vote_result_id: vote_result_id,
					congressman_id: congressman_id
				  },
				  dataType: "json",
				  method: "post"
				}).done(function(data) {
					if (data.success)
					{
						$("#window-error").html("");
						$("#window-error").css("display", "none");
						current_btn.parent().find(".btn-vote").addClass("grayed");
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
		
		// Delete vote action
		$(".btn-delete-congressman").on("click", function() {
			if (confirm("Esto eliminará el voto seleccionado. ¿Está seguro?"))
			{
				var law_id = $("#law_id").val();
				var congressman_id = $(this).parent().parent().attr("data-congressman_id");
				var element = $(this);

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/delete_vote",
				  data: {
					law_id: law_id,
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

		// Delete all votes action
		$("#btn-delete-congressmen").on("click", function() {
			if (confirm("Esto eliminará todos los voto ingresados en la inciativa seleccionada. ¿Está seguro?"))
			{			
				var law_id = $("#law_id").val();

				$.ajax({
				  url: site_url + "admin/' . $this->module_name . '/delete_all_votes",
				  data: {
					law_id: law_id
				  },
				  dataType: "json",
				  method: "post"
				}).done(function(data) {
					if (data.success)
					{
						$("#window-error").html("");
						$("#window-error").css("display", "none");
						$(".vote-table-data").remove();
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
			var law_id = $("#law_id").val();
			var congressman_id = $("#congressman_id").val();

			$.ajax({
			  url: site_url + "admin/' . $this->module_name . '/add_congressman",
			  data: {
				law_id: law_id,
				congressman_id: congressman_id
			  },
			  dataType: "json",
			  method: "post"
			}).done(function(data) {
				if (data.success)
				{
					$("#window-error").html("");
					$("#window-error").css("display", "none");
					$("#form-vote").submit();
				}
				else
				{
					$("#window-error").html(data.error_message);
					$("#window-error").show("display", "fast");
				}
			});
		});
		
		// Laws options
		var law_select_options = {
		  language: \'es\',
		  id: function(law) { return law.law_id; },
		  ajax: {
			url: site_url + "admin/' . $this->module_name . '/search_laws",
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
		  templateResult: function (law) {
		  if (law.loading) return law.text;

		  var markup = \'<div class="clearfix">\' +
			\'<div clas="col-sm-12">\' +
			  \'<div class="clearfix">\' +
				\'<div class="col-sm-6"><strong>Nombre:</strong> \' + law.name + \'</div>\' +
				\'<div class="col-sm-3"><strong>No.:</strong> \' + law.number + \'</div>\' +
				\'<div class="col-sm-2"><strong>Fecha:</strong> \' + law.presentation_date + \'</div>\' +
			  \'</div>\';

		  markup += \'</div></div>\';

		  return markup;
		},
		  templateSelection: function (law) {
			if (typeof(law.name) != \'undefined\')
			{
				$(\'#law_id\').val(law.law_id);
				
				$("#form-vote").submit();
				
				return law.name;
			}
			else
			{
				return $(\'#default_law_text\').val();
			}
		  }
		};
		
		$("#law-search").select2(law_select_options);

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
				law_id: $(\'#law_id\').val()
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
		$this->load->view('vote', $this->data_parts);
	}

	/**
	 * Change congressman vote
	 *
	 * Changes congressman vote
	 *
	 * @param	none
	 * @return	none
	 */
	public function change_vote_result()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$law_id			 	= intval($this->input->post('law_id'));
		$vote_result_id 	= intval($this->input->post('vote_result_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($law_id <= 0)
			$error_message = "Debe seleccionar una iniciativa.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->vote_model->insert_vote($law_id, $congressman_id, date('Y-m-d H:i:s'), $vote_result_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se ingresó voto de diputado con ID ' . $congressman_id . ' sobre iniciativa con ID ' . $law_id . '.');
			
			$error_message = $result ? '' : 'No se pudo cambiar voto.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}

	/**
	 * Add congressman
	 *
	 * Adds congressman to the vote list
	 *
	 * @param	none
	 * @return	none
	 */
	public function add_congressman()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$law_id			 	= intval($this->input->post('law_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($law_id <= 0)
			$error_message = "Debe seleccionar una iniciativa.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->vote_model->insert_vote($law_id, $congressman_id, null, VOTE_RESULT_ID_NONE);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se agregó diputado con ID ' . $congressman_id . ' al listado de votos sobre iniciativa con ID ' . $law_id . '.');
			
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
	 * Deletes congressman from vote list
	 *
	 * @param	none
	 * @return	none
	 */
	public function delete_vote()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$law_id			 	= intval($this->input->post('law_id'));
		$congressman_id 	= intval($this->input->post('congressman_id'));

		if ($law_id <= 0)
			$error_message = "Debe seleccionar una iniciativa.";
		elseif ($congressman_id <= 0)
			$error_message = "Debe seleccionar un diputado.";
		
		if (!$error_message)
		{		
			$result = $this->vote_model->delete_vote($law_id, $congressman_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó voto de diputado con ID ' . $congressman_id . ' sobre iniciativa con ID ' . $law_id . '.');
			
			$error_message = $result ? '' : 'No se pudo eliminar voto.';
		}
		
		$data	= array('success' => $result,
						'error_message' => $error_message);
	
        echo json_encode($data);
		die;		
	}
	
	/**
	 * Delete all congressmen
	 *
	 * Deletes all congressmen from vote list
	 *
	 * @param	none
	 * @return	none
	 */
	public function delete_all_votes()
	{
		$error_message 		= '';
		$result 			= FALSE;
		
		$law_id			 	= intval($this->input->post('law_id'));

		if ($law_id <= 0)
			$error_message = "Debe seleccionar una iniciativa.";
		
		if (!$error_message)
		{		
			$result = $this->vote_model->delete_all($law_id);

			if ($result)
				$this->admin_model->add_to_log($this->session->get_user_id(), 'Se eliminó votos de todos los diputados sobre iniciativa con ID ' . $law_id . '.');
			
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
		$law_id		= $this->input->get('law_id');
		$this->load->helper('json');
		
		$users 	= $this->vote_model->search_eligible_congressmen($law_id, $searchterm, $page);
		
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
	function search_laws()
	{	
		$searchterm	= $this->input->get('term');
		$page		= $this->input->get('page');
		$law_id		= $this->input->get('law_id');
		$this->load->helper('json');
		
		$users 	= $this->law_model->search_laws($searchterm, $page);
		
		$data	= array('total_count' => $users->total,
						'items' => $users->laws);
	
        echo json_encode($data);
		die;
	}
}