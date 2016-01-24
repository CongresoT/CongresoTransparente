<?php
/**
  * Congressman controller
  *
  * This is the controller to handle the congressman part on the public site.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Congressman/Controllers
  */
class Congressman extends MY_Controller {
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
        $this->load->model('congressman_model', 'congressman_model',TRUE);
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
		$this->set_title('Diputados');
		
		$this->load->model('district_model', 'district_model',TRUE);
		$this->load->model('political_party_model', 'political_party_model',TRUE);		
		
		$this->add_css_url('jquery.dataTables.min');
		$this->add_js_url('jquery.dataTables.min');
		$this->add_js_startup('$("#congressman-list").DataTable({
			"sDom": \'<"top">rt<"bottom"ip><"clear">\',
			"iDisplayLength": 10,
			"language": {
				"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
			}
		});
		
		$("#district_id").change(function() {
			$("#frmSearch").submit();
		});

		$("#political_party_id").change(function() {
			$("#frmSearch").submit();
		});
		
		$(".congressman-row").css("cursor", "pointer");
		
		$(".congressman-row").click(function() {
			var congressman_id = $(this).attr("congressman-id");
			window.location = site_url + "diputado/" + congressman_id;
		});	
		
		');
		
		$searchquery = $this->input->post('searchquery', TRUE);
		$district_id = intval($this->input->post('district_id'));
		$political_party_id = intval($this->input->post('political_party_id'));
		
		$filters = array();
		$filters['active'] = 1;
		if ($district_id > 0)
			$filters['district_id'] = $district_id;
		if ($political_party_id > 0)
			$filters['political_party_id'] = $political_party_id ;
		$filters['search'] = $searchquery;

		$district_list = $this->district_model->get_list();
		$political_party_list = $this->political_party_model->get_active_list();

		$list = $this->congressman_model->get_list($filters);
		
		$district_options = array('0' => '-- Todos --');
		foreach ($district_list as $option)
			$district_options[$option->district_id] = $option->name;
			
		$political_party_options = array('0' => '-- Todos --');
		foreach ($political_party_list as $option)
			$political_party_options[$option->political_party_id] = $option->full_name;
		
		$this->load->view('congressman_list', array('list' => $list,
			'searchquery' => $searchquery,
			'district_options' => $district_options,
			'district_id' => $district_id,
			'political_party_options' => $political_party_options,
			'political_party_id' => $political_party_id)
		);
	}
	
	function congressman_profile($congresman_id) {
		$this->set_title('Perfil de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));

		if ($congressman)
		{		
			$this->set_title('Perfil de ' . $congressman->names . ' ' . $congressman->last_names);
			
			$this->load->view('congressman_profile', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id)
			);
		}
		else
			show_404();
	}
	
	function congressman_votes($congresman_id) {
		$this->set_title('Votaciones de diputados');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('Votaciones de ' . $congressman->names . ' ' . $congressman->last_names);
	
			$this->load->model('law_type_model', 'law_type_model',TRUE);	
	
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#congressman-votes-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				},
				"columns": [
					{ "width": "70%", "className": "law" },
					{ "width": "30%", "className": "vote" }
				  ],
				"ordering": false,
				"initComplete": function(settings, json) {
					$("#congressman-votes-list thead tr th").css("padding", "0");
				}
			});
			
			$(".btn-law-type").click(function() {
				$("input[name=law_type_id]").val($(this).attr("law-type-id"));
				$("#frmSearch").submit();
			});

			$(window).bind("resizeEnd", function() {
			});			
			
			function resize_buttons() {
				var btn_max_height = 0;				
				$(".congressman-votes .search-form .law-type .btn-law-type .law-type-text").each(function() {
					btn_max_height = ($(this).innerHeight() > btn_max_height ? $(this).innerHeight() : btn_max_height);
				});
				
				$(".congressman-votes .search-form .law-type .btn-law-type .law-type-text").each(function() {
					$(this).css("margin", ((btn_max_height * 1.5 - $(this).innerHeight()) / 2) + "px 3%")
				});
			}
			
			resize_buttons();
			
			$(window).resize(function() {
				resize_buttons();
			});
			
			$(".congressman-vote-row .law").click(function() {
				var law_id = $(this).attr("law-id");
				window.location = site_url + "actividad_legislativa/" + law_id;
			});	
			');
	
			$searchquery = $this->input->post('searchquery', TRUE);
			$law_type_id = intval($this->input->post('law_type_id'));
	
			$filters = array();
			if ($law_type_id > 0)
				$filters['law_type_id'] = $law_type_id;
			$filters['search'] = $searchquery;
	
			$law_type_list = $this->law_type_model->get_list();	
			$vote_list	= $this->congressman_model->get_votes($congresman_id, $filters);
	
			$this->load->view('congressman_votes', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'law_type_id' => $law_type_id,
				'searchquery' => $searchquery,
				'law_type_list' => $law_type_list,
				'vote_list' => $vote_list)
			);		
		}
		else
			show_404();
	}
	
	function congressman_attendance($congresman_id) {
		$this->set_title('Asistencia de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('Asistencia de ' . $congressman->names . ' ' . $congressman->last_names);
	
			$this->add_js_url('highcharts');

			$total	= 0;
			$graph_data_array = array();
			
			$attendance_list	= $this->congressman_model->get_attendance($congresman_id);
			if (is_array($attendance_list))
			{
				foreach ($attendance_list as $element)
				{
					$total += $element->total;
					$graph_data_array[] = '{
										name: "' . $element->name . '",
										y: ' . $element->total . ',
										color: "#' . $element->color . '",
										dataLabels: {
											enabled: false
										}
									}';
				}
			}

			$this->add_js_startup('
				function resize_squares() {
					var max_width = 0;
					$(".congressman-attendance-total").each(function(index) {
						max_width = $(this).width() > max_width ? $(this).width() : max_width;
					});
					$(".congressman-attendance-total").css("height", max_width);
					$(".congressman-attendance-total").css("width", max_width);
				}
			
				$(document).resize(function() {
					$(".congressman-attendance-total").css("height", "");
					$(".congressman-attendance-total").css("width", "");
					resize_squares();
				})
			
				$(document).ready(function(){
					resize_squares();
				});
			
			
				$("#graph-container").highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: 0,
							plotShadow: false,
							spacingBottom: 0,
							spacingTop: 0
						},
						title: {
							text: "' . $total . '",
							align: "center",
							verticalAlign: "middle",
							style: {
										fontSize: "5em",
										color: "#515151"
									},
							y: 90
						},
						tooltip: {
							pointFormat: "{series.name}: <b>{point.y}</b>"
						},
						plotOptions: {
							pie: {
								dataLabels: {
									enabled: true,
									distance: -50,
									style: {
										fontWeight: "bold",
										color: "white",
										textShadow: "0px 1px 2px black"
									}
								},
								startAngle: -90,
								endAngle: 90,
								center: ["50%", "75%"]
							}
						},
						series: [{
							type: "pie",
							name: "Cantidad",
							innerSize: "50%",
							data: [' . implode(',', $graph_data_array) . '				
							]
						}]
					});			
			');	
			
			$this->load->view('congressman_attendance', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'total' => $total, 
				'attendance_list' => $attendance_list)
			);		
		}
		else
			show_404();
	}
	
	function congressman_parties($congresman_id) {
		$this->set_title('Bancadas de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{		
			$this->set_title('Bancadas de ' . $congressman->names . ' ' . $congressman->last_names);
	
			$political_parties_list	= $this->congressman_model->get_political_parties($congresman_id);
	
			$this->load->view('congressman_political_parties', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'political_parties_list' => $political_parties_list)
			);		
		}
		else
			show_404();		
	}
	
	function congressman_laws($congresman_id) {
		$this->set_title('Leyes propuestas por diputado ');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('Leyes propuestas por ' . $congressman->names . ' ' . $congressman->last_names);
	
			$this->load->model('law_type_model', 'law_type_model',TRUE);	
	
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#congressman-laws-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				},
				"ordering": false,
				"initComplete": function(settings, json) {
					$("#congressman-laws-list thead tr th").css("padding", "0");
				}
			});
			
			$(".btn-law-type").click(function() {
				$("input[name=law_type_id]").val($(this).attr("law-type-id"));
				$("#frmSearch").submit();
			});

			$(window).bind("resizeEnd", function() {
			});			
			
			function resize_buttons() {
				var btn_max_height = 0;				
				$(".congressman-laws .search-form .law-type .btn-law-type .law-type-text").each(function() {
					btn_max_height = ($(this).innerHeight() > btn_max_height ? $(this).innerHeight() : btn_max_height);
				});
				
				$(".congressman-laws .search-form .law-type .btn-law-type .law-type-text").each(function() {
					$(this).css("margin", ((btn_max_height * 1.5 - $(this).innerHeight()) / 2) + "px 3%")
				});
			}
			
			resize_buttons();
			
			$(window).resize(function() {
				resize_buttons();
			});
			
			$(".congressman-law-row").click(function() {
				var law_id = $(this).attr("law-id");
				window.location = site_url + "actividad_legislativa/" + law_id;
			});				
			');
	
			$searchquery = $this->input->post('searchquery', TRUE);
			$law_type_id = intval($this->input->post('law_type_id'));
	
			$filters = array();
			if ($law_type_id > 0)
				$filters['law_type_id'] = $law_type_id;
			$filters['search'] = $searchquery;
	
			$law_type_list = $this->law_type_model->get_list();	
			$laws_list	= $this->congressman_model->get_laws($congresman_id, $filters);
	
			$this->load->view('congressman_laws', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'law_type_id' => $law_type_id,
				'searchquery' => $searchquery,
				'law_type_list' => $law_type_list,
				'laws_list' => $laws_list)
			);		
		}
		else
			show_404();
	}
	
	function congressman_citations($congresman_id) {
		$this->set_title('Citciones de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('Citaciones de ' . $congressman->names . ' ' . $congressman->last_names);
	
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#congressman-citations-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"columns": [
					{ "width": "95%" },
					{ "width": "5%" }
				  ],				
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				}
			});
			');

			$citations_list	= $this->congressman_model->get_citations($congresman_id);
	
			$this->load->view('congressman_citations', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'citations_list' => $citations_list)
			);		
		}
		else
			show_404();		
	}
	
	function congressman_comissions($congresman_id) {
		$this->set_title('Comisiones de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('Comisiones de ' . $congressman->names . ' ' . $congressman->last_names);
	
			$this->add_css_url('jquery.dataTables.min');
			$this->add_js_url('jquery.dataTables.min');	
			$this->add_js_startup('$("#congressman-commissions-list").DataTable({
				"sDom": \'<"top">rt<"bottom"ip><"clear">\',
				"iDisplayLength": 10,
				"columns": [
					{"className": "commission"},
					null,
					null
				],
				"language": {
					"url": "' . site_url('assets/js/datatables_plugins/Spanish.json') . '"
				}
			});
			$(".congressman-commission-row .commission").click(function() {
				var comission_id = $(this).attr("comission-id");
				window.location = site_url + "comision/" + comission_id;
			});							
			');

			$commissions_list	= $this->congressman_model->get_comissions($congresman_id);
	
			$this->load->view('congressman_comissions', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'commissions_list' => $commissions_list)
			);		
		}
		else
			show_404();				
	}
	
	function congressman_cv($congresman_id) {
		$this->set_title('CV de diputado');
		
		$congressman = $this->congressman_model->get(intval($congresman_id));
		
		if ($congressman)
		{	
			$this->set_title('CV de ' . $congressman->names . ' ' . $congressman->last_names);
			
			$this->load->view('congressman_cv', array('congressman_info' => $this->load->view('congressman_info', array('congressman' => $congressman), TRUE),
				'congressman_id' => $congresman_id, 
				'congressman' => $congressman)
			);		
		}
		else
			show_404();				
	}	
}