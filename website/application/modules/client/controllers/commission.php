<?php
/**
  * Commission controller
  *
  * This is the controller to handle the commission part on the public site.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Commission/Controllers
  */
class Commission extends MY_Controller {
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
        $this->load->model('commission_model', 'commission_model',TRUE);
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
		$this->set_title('Comisiones');
	
		$this->add_css_url('jquery.dataTables.min');
		$this->add_js_url('jquery.dataTables.min');
		$this->add_js_startup('$("#commission-list").DataTable({
			"sDom": \'<"top">rt<"bottom"ip><"clear">\',
			"iDisplayLength": 10,
			"language": {
				"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
			}
		});

		$(".commission-row").click(function() {
			var commission_id = $(this).attr("commission-id");
			window.location = site_url + "comision/" + commission_id;
		});			
		');
		
		$searchquery = $this->input->post('searchquery', TRUE);
		
		$filters = array();
		$filters['search'] = $searchquery;

		$list = $this->commission_model->get_list($filters);
				
		$this->load->view('commission_list', array('list' => $list,
			'searchquery' => $searchquery)
		);
	}
	
	function commission_profile($commission_id) {
		$this->set_title('Comisión');
		
		$searchquery = $this->input->post('searchquery', TRUE);
		$filters = array();
		$filters['search'] = $searchquery;
		
		$list = $this->commission_model->get_congressman(intval($commission_id), $filters);

		if ($list)
		{	
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');
			$this->add_js_startup('$("#commission-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				}
			});

			$(".commission-row").click(function() {
				var congressman_id = $(this).attr("congressman-id");
				window.location = site_url + "diputado/" + congressman_id;
			});			
			');	
	
			$this->load->view('commission_profile',
				array('commission_id' => $commission_id,
				'list' => $list,
				'searchquery' => $searchquery)
			);		
		}
		else
			show_404();
	}
}