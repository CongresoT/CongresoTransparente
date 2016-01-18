<?php
/**
  * Law controller
  *
  * This is the controller to handle the law part on the public site.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Law/Controllers
  */
class Law extends MY_Controller {
/**
  * Class constructor
  *
  * Loads some of the common libraries, helpers and models used on the class
  *
  * @param	none
  * @return	none
  */
	function  __construct() {
		parent::__construct();
		
		$this->load->helper('language');
		$this->load->helper('url');
		$this->load->helper('form');
		
		// BEGIN: Load models
        $this->load->model('law_model', 'law_model',TRUE);
		// END: Load models				
	}
	
/**
  * Main entry point
  *
  * This the main entry point for the congressmen controller.
  * 
  *
  * @param	none
  * @return	none
  */	
	function index()
	{
		$this->load->model('law_type_model', 'law_type_model',TRUE);
		$this->load->model('law_status_model', 'law_status_model',TRUE);
		$this->load->model('commission_model', 'commission_model',TRUE);
		
		$this->add_css_url('jquery.dataTables.min');
		$this->add_js_url('jquery.dataTables.min');
		$this->add_js_startup('$("#law-list").DataTable({
			"sDom": \'<"top">rt<"bottom"ip><"clear">\',
			"iDisplayLength": 10,
			"language": {
				"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
			}
		});
		
		$("#law_type_id").change(function() {
			$("#frmSearch").submit();
		});

		$("#law_status_id").change(function() {
			$("#frmSearch").submit();
		});

		$("#commission_id").change(function() {
			$("#frmSearch").submit();
		});
		
		$(".law-row").css("cursor", "pointer");
		
		$(".law-row").click(function() {
			var law_id = $(this).attr("law-id");
			window.location = site_url + "actividad_legislativa/" + law_id;
		});		
		
		');
		
		$searchquery = $this->input->post('searchquery', TRUE);
		$law_type_id = intval($this->input->post('law_type_id'));
		$law_status_id = intval($this->input->post('law_status_id'));
		$commission_id = intval($this->input->post('commission_id'));
		
		$filters = array();
		$filters['active'] = 1;
		if ($law_type_id > 0)
			$filters['law_type_id'] = $law_type_id;
		if ($law_status_id > 0)
			$filters['law_status_id'] = $law_status_id ;
		if ($commission_id > 0)
			$filters['commission_id'] = $commission_id ;
		$filters['search'] = $searchquery;

		$law_type_list = $this->law_type_model->get_list();
		$law_status_list = $this->law_status_model->get_list();
		$commission_list = $this->commission_model->get_list_from_laws();

		$list = $this->law_model->get_list($filters);
		
		$law_type_options = array('0' => '-- Todos --');
		foreach ($law_type_list as $option)
			$law_type_options[$option->law_type_id] = $option->name;
			
		$law_status_options = array('0' => '-- Todos --');
		foreach ($law_status_list as $option)
			$law_status_options[$option->law_status_id] = $option->name;

		$commission_options = array('0' => '-- Todos --');
		if ($commission_list)
			foreach ($commission_list as $option)
				$commission_options[$option->commission_id] = $option->name;
		
		$this->load->view('laws_list', array('list' => $list,
			'searchquery' => $searchquery,
			'law_type_options' => $law_type_options,
			'law_type_id' => $law_type_id,
			'law_status_options' => $law_status_options,
			'law_status_id' => $law_status_id,
			'commission_options' => $commission_options,
			'commission_id' => $commission_id)
		);
	}
	
	function law_profile($law_id) {
		$law = $this->law_model->get(intval($law_id));

		if ($law)
		{		
			$this->load->model('law_status_model', 'law_status_model',TRUE);
			
			$law_status_id = $law->law_status_id;
			
			$congressman_list = $this->law_model->get_congressmen(intval($law_id));
			$person_list = $this->law_model->get_persons(intval($law_id));

			$law_status_list = $this->law_status_model->get_list();	
			
			$this->load->view('law_profile', array('law_info' => $this->load->view('law_info', array('law' => $law, 'congressman_list' => $congressman_list,'person_list' => $person_list), TRUE),
				'law_id' => $law_id,
				'law_status_id' => $law_status_id,
				'law_status_list' => $law_status_list)
			);		
		}
		else
			show_404();
	}
	
	function law_votes($law_id) {
		$law = $this->law_model->get(intval($law_id));
		
		if ($law)
		{	
			$this->load->model('political_party_model', 'political_party_model',TRUE);	

			$congressman_list = $this->law_model->get_congressmen(intval($law_id));
			$person_list = $this->law_model->get_persons(intval($law_id));
			
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#law-votes-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				},
				"columns": [
					{ "width": "50%" },
					{ "width": "45%" },
					{ "width": "5%" }
				  ],
				"ordering": false
			});
			
			$("#political_party_id").change(function() {
				$("#frmSearch").submit();
			});
			');
	
			$searchquery = $this->input->post('searchquery', TRUE);
			$political_party_id = intval($this->input->post('political_party_id'));
	
			$filters = array();
			if ($political_party_id > 0)
				$filters['political_party_id'] = $political_party_id;
			$filters['search'] = $searchquery;
	
			$political_party_list = $this->political_party_model->get_list();
			$political_party_options = array('0' => '-- Todas --');
			foreach ($political_party_list as $option)
				$political_party_options[$option->political_party_id] = $option->short_name;			
			
			$vote_list	= $this->law_model->get_votes($law_id, $filters);
	
			$this->load->view('law_votes', array('law_info' => $this->load->view('law_info', array('law' => $law, 'congressman_list' => $congressman_list,'person_list' => $person_list), TRUE),
				'law_id' => $law_id, 
				'political_party_id' => $political_party_id,
				'searchquery' => $searchquery,
				'political_party_options' => $political_party_options,
				'vote_list' => $vote_list)
			);
		}
		else
			show_404();
	}
	
	function law_rulings($law_id) {
		$law = $this->law_model->get(intval($law_id));
		
		if ($law)
		{	
			$this->load->model('political_party_model', 'political_party_model',TRUE);	

			$congressman_list = $this->law_model->get_congressmen(intval($law_id));
			$person_list = $this->law_model->get_persons(intval($law_id));
			
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#law-rulings-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				},
				"ordering": false
			});
			
			$("#political_party_id").change(function() {
				$("#frmSearch").submit();
			});
			');
	
			$searchquery = $this->input->post('searchquery', TRUE);
			$political_party_id = intval($this->input->post('political_party_id'));
	
			$filters = array();
			if ($political_party_id > 0)
				$filters['political_party_id'] = $political_party_id;
			$filters['search'] = $searchquery;
	
			$political_party_list = $this->political_party_model->get_list();
			$political_party_options = array('0' => '-- Todas --');
			foreach ($political_party_list as $option)
				$political_party_options[$option->political_party_id] = $option->short_name;			
			
			$ruling_list	= $this->law_model->get_rulings($law_id, $filters);
	
			$this->load->view('law_rulings', array('law_info' => $this->load->view('law_info', array('law' => $law, 'congressman_list' => $congressman_list,'person_list' => $person_list), TRUE),
				'law_id' => $law_id, 
				'political_party_id' => $political_party_id,
				'searchquery' => $searchquery,
				'political_party_options' => $political_party_options,
				'ruling_list' => $ruling_list)
			);
		}
		else
			show_404();
	}
	
	function law_timeline($law_id) {
		$law = $this->law_model->get(intval($law_id));
		
		if ($law)
		{	
			$this->load->model('political_party_model', 'political_party_model',TRUE);	

			$congressman_list = $this->law_model->get_congressmen(intval($law_id));
			$person_list = $this->law_model->get_persons(intval($law_id));
			
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#law-timeline-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				},
				"ordering": false
			});
			
			$("#political_party_id").change(function() {
				$("#frmSearch").submit();
			});
			');
	
			$searchquery = $this->input->post('searchquery', TRUE);
	
			$timeline_list	= $this->law_model->get_timeline($law_id);
	
			$this->load->view('law_timeline', array('law_info' => $this->load->view('law_info', array('law' => $law, 'congressman_list' => $congressman_list,'person_list' => $person_list), TRUE),
				'law_id' => $law_id, 
				'searchquery' => $searchquery,
				'timeline_list' => $timeline_list)
			);
		}
		else
			show_404();
	}
}