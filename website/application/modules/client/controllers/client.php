<?php
/**
  * Client controller
  *
  * This is the controller to handle the main public site.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Public/Client/Controllers
  */
class Client extends MY_Controller {
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
        $this->load->model('content_model', 'content_model',TRUE);
		// END: Load models				
	}
	
/**
  * Main entry point
  *
  * This the main entry point for the client controller.
  * 
  *
  * @param	none
  * @return	none
  */	
	function index()
	{
		$main_content = $this->content_model->get(CONTENT_ABOUT_US)->content;
		$ad_content = $this->content_model->get(CONTENT_FRONTPAGE_AD)->content;
		
		$this->load->view('main', array('main_content' => $main_content,
		'ad_content' => $ad_content));
	}
}
