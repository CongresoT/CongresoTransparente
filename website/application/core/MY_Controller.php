<?php
/**
  * Core controller
  *
  * This is the main controller for the Freequent site.
  *  
  * @package	Public/Core/Controllers
  */
class MY_Controller extends CI_Controller
{
/**
 * Properties for this controller.
 *
 */

/**
 * @property string $module_name Module name
 */
    protected $module_name;
/**
 * @property string $data_parts Data parts
 */
    protected $data_parts;
/**
 * @property string $views views to load
 */
    protected $views;
/**
 * @property string $meta Meta tags
 */
    protected $meta;
/**
 * @property string $title Site title
 */
    protected $title;
/**
 * @property string $css_url CSS files
 */
    protected $css_url;
/**
 * @property string $css_scripts CSS snippets
 */
    protected $css_scripts;
/**
 * @property string $js_url JS files
 */
    protected $js_url;
/**
 * @property string $js_scripts JS snippets
 */
    protected $js_scripts;
/**
 * @property string $js_startup JS startup snippets
 */
    protected $js_startup;
/**
 * @property string $js_startup JS bottom snippets
 */
    protected $js_bottom;
/**
 * @property string $meta Template theme
 */
    protected $theme;
/**
 * @property string $grocery_crud_content Grocery CRUD render
 */
    protected $grocery_crud_content;
	
/**
 * @property array $parameters System parameters
 */
    public $parameters;

/**
  * Class constructor
  *
  * Loads some of the common libraries, helpers and models used on the class
  *
  * @access	public
  * @param	none
  * @return	none
  */
    function __construct($template_name = NULL) {
        parent::__construct();
		// Get system parameters
		// BEGIN: Load models
        $this->load->model('general/parameter_model', 'parameter_model', TRUE);
		// END: Load models		
		$this->parameters	= $this->parameter_model->get_parameters();
		
		// Set default site title
		$this->title = DEFAULT_SITE_TITLE;
        
		// Detects if the user is using and old browser that is known to have some issues with the app and gets a custom message to warn the user
		$browser_warning_message = $this->get_browser_warning();

		// Set the template parts only if there's a template set
		if ($template_name !== NULL)
            $this->layout->set_template($template_name);
            $this->layout->set_parts(array(
            'footer' => '',
			'system_messages' => '',
			'browser_warning' => ($browser_warning_message != ''),
			'browser_mesage' => $browser_warning_message
        ));
        $this->meta = array(
            'description' => DEFAULT_SITE_DESCRIPTION,
            'keywords' => DEFAULT_SITE_KEYWORDS
        );
		
		$this->css_url 				= array();
		$this->css_scripts 			= array();
		$this->js_scripts	 		= array();
		$this->js_url	 			= array();
		$this->js_startup 			= array();
		$this->js_bottom 			= array();
		$this->system_messages		= array();
		$this->grocery_crud_content	= '';


    $this->add_css_url('bootstrap.min');
	$this->add_css_url('style');

    //$this->add_js_url('foundation.min');
    //$this->add_js_url('ofs-scripts');
	
    $this->add_js_url('jquery.min');
	$this->add_js_url('jquery-ui-1.10.3.custom.min');
	$this->add_js_url('bootstrap.min');
    $this->add_js_url('camera.min');

    if ($template_name != 'admin')
    {
		$this->add_js_url('client');
		$this->add_css_url('client');
    }
    else
    {
      $this->add_css_url('font-awesome');
    }

	$this->add_js_url('common'); 

        $this->add_js_script('var site_url = "'.site_url().'"');
		       	
        $this->load->helper('form');
        $this->load->driver('cache', array('adapter'=>'file'));
		$this->load->library('authentication', array('session'=> &$this->session));
      if ($template_name != 'admin')
      {
        $this->data_parts['is_auth'] = $this->session->is_authenticated() && $this->session->is_student();
        if ($this->data_parts['is_auth'])
        {
          $this->data_parts['user_info'] = $this->session->get_user_info();
        }
      }
    }

/**
  * Set title
  *
  * Sets the title of the page. This is used on the <title></title> tags of the page.
  *
  * @access	public  
  * @param	string	Page title.
  * @return	none
  */
    function set_title($title) {
        $this->title = DEFAULT_SITE_TITLE . ' :: ' . $title;
    }

/**
  * Get title
  *
  * Gets the current page title.
  *
  * @access	public  
  * @param	none
  * @return	string	The current page title.
  */
    function get_title() { 
		return $this->title; 
	}

/**
  * Set description
  *
  * Sets the description of the page. This is used on the description meta tags of the page.
  *
  * @access	public  
  * @param	string	Page description.
  * @return	none
  */
    function set_description($description) {
        $this->meta['description'] = $description;
    }

/**
  * Get description
  *
  * Gets the current page description.
  *
  * @access	public  
  * @param	none
  * @return	string	The current page description.
  */	
    function get_description() { 
		return $this->meta['description']; 
	}

/**
  * Set keywords
  *
  * Sets the keywords of the page. This is used on the keywords meta tags of the page.
  *
  * @access	public  
  * @param	string	Page keywords
  * @return	none
  */
    function set_keywords($keywords) {
        $this->meta['keywords'] = $keywords;
    }

/**
  * Get keywords
  *
  * Gets the current page keywords.
  *
  * @access	public  
  * @param	none
  * @return	string	The current keywords.
  */
    function get_keywords() { 
		return $this->meta['keywords']; 
	}

/**
  * Set meta info
  *
  * Sets a meta info tag of the page. This is used on custom meta tags of the page.
  * For example, it can be used to set a custom "robots" meta tag.
  *
  * @access	public  
  * @param	string	Meta tag name.
  * @param	string	Meta tag value.
  * @return	none
  */
    function set_metainfo($name, $value) {
        $this->meta[$name] = $value;
    }

/**
  * Get meta info
  *
  * Gets a meta tag from the current page.
  *
  * @access	public  
  * @param	string	A meta tag name.
  * @return	string	The current keywords.
  */
    function get_metainfo($name) { 
		return $this->meta[$name]; 
	}

/**
  * Add a JS library
  *
  * Adds a JS library to the page.
  *
  * @access	public  
  * @param	string	JS library name. NOTE: The library has to be on assets/js (example: "my-library" and not "my-library.js").
  * @return	none
  */
    function add_js_url($src) {
        if (!in_array($src, $this->js_url))
        {
            $this->js_url []= $src;
        }
    }

/**
  * Add a CSS file
  *
  * Adds a CSS file to the page.
  *
  * @access	public  
  * @param	string	CSS file name. NOTE: The file has to be on assets/css/ without extension (example: "my-css" and not "my-css.css").
  * @return	none
  */
    function add_css_url($src) {	
        if (!is_array($this->css_url) or !in_array($src, $this->css_url))
        {           		
            $this->css_url []= $src;
        }
    }

/**
  * Add a JS snippet at the top of the page
  *
  * Adds a JS snippet at the top of the page.
  *
  * @access	public  
  * @param	string	JS snippet.
  * @return	none
  */
    function add_js_script($script) {
        if (!in_array($script, $this->js_scripts))
            $this->js_scripts []= $script;
    }

/**
  * Add a JS snippet at the bottom of the page
  *
  * Adds a JS snippet at the bottom of the page.
  *
  * @access	public  
  * @param	string	JS snippet.
  * @return	none
  */
    function add_js_bottom($script) {
        if (!in_array($script, $this->js_bottom))
            $this->js_bottom []= $script;
    }

/**
  * Add a JS snippet at startup
  *
  * Adds a JS snippet to be executed when the page loads.
  *
  * @access	public  
  * @param	string	JS snippet.
  * @return	none
  */
    function add_js_startup($script) {
        if (!in_array($script, $this->js_startup))
            $this->js_startup []= $script;
    }

/**
  * Add a CSS snippet
  *
  * Adds a CSS snippet.
  *
  * @access	public  
  * @param	string	CSS snippet.
  * @return	none
  */
    function add_css_script($script) {
        if (!in_array($script, $this->css_scripts))
            $this->css_scripts []= $script;
    }

/**
  * Set a CSS theme
  *
  * Sets a CSS theme.
  *
  * @access	public  
  * @param	string	CSS theme name.
  * @return	none
  */
    function set_theme($theme) {
        $this->theme = $theme;
    }

/**
  * Add system message
  *
  * Adds a system message to be displayed in the site.
  *
  * @access	public  
  * @param	string	Message (html).
  * @param	string	Message style: information, warning, error (default: information).
  * @return	none
  */
    function add_system_message($msg, $msg_style = SYS_MSG_STYLE_INFO) {
        $this->system_messages[] = (object) array('text' => $msg, 'style' => $msg_style);
    }
	
/**
  * Get system messages
  *
  * Gets all system messagess in HTMl format
  *
  * @access	public  
  * @param	string	Message (html).
  * @return	none
  */
    function get_formatted_system_messages() {
		$html	= '';
		$class	= '';
		if (count($this->system_messages) > 0)
			foreach ($this->system_messages as $item)
			{
				switch ($item->style)
				{
					case SYS_MSG_STYLE_SUCCESS:
						$class 		= "alert alert-success";
					break;
					case SYS_MSG_STYLE_WARNING:
						$class 		= "alert alert-warning";
					break;
					case SYS_MSG_STYLE_ERROR:
						$class 		= "alert alert-danger";
					break;
					default:
						$class 		= "alert alert-info";
				}
				$html	.= '<div class="' . $class . '">' . $item->text . '</div>';
			}
		return $html;
    }

/**
  * Get browser warning
  *
  * Gets a message if a warning has to be issue for an older browser
  *
  * @access	public
  * @param	none
  * @return	string	Warning message (empty string if no warning is issued)
  */
	public function get_browser_warning() {
		$msg	= '';
		
		if (($this->agent->browser() == 'Internet Explorer') && ($this->agent->version() <= 8)) 
		{
			$msg	= sprintf($this->lang->line('warning_browser_internet_explorer'), $this->agent->browser() . ' ' . $this->agent->version());
		} elseif (($this->agent->browser() == 'Firefox') && ($this->agent->version() < 4)) 
		{
			$msg	= sprintf($this->lang->line('warning_browser_firefox'), $this->agent->browser() . ' ' . $this->agent->version());
		}

		return $msg;
	}	
	
/**
  * Get current Page URL
  *
  * Gets the full current page URL
  *
  * @access	public  
  * @param	none
  * @return	string	Current page URL
  */
	public function current_page_url() {
		$pageURL = 'http://';
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
/**
  * Set a data part
  *
  * Sets a data part
  *
  * @access	public  
  * @param	none
  * @return	string	Current page URL
  */
	public function set_data_part($field, $value) {
		$this->data_parts[$field]	= $value;
	}
	
/**
  * Ouput template
  *
  * Outputs the template to the browser
  *
  * @access	public  
  * @param	string	Output
  * @return	none
  */
    public function _output($output) {
		
		// Load outdated processes message
		if ($this->session->userdata('outdated_processes_msg') != '')
		{
			$this->add_system_message($this->session->userdata('outdated_processes_msg'), SYS_MSG_STYLE_WARNING);
			$this->session->set_userdata('outdated_processes_msg', '');
		}
	
		// If there's a message to show, load it and add it to the template
        $message = $this->session->flashdata('message');

        if (!empty($message))
            $this->js_scripts []= "$(document).ready(function(){showAlert('$message');});";
        $template_name = $this->layout->get_template();

		// If the user is not logged in, show the login popup
        if (!$this->session->is_authenticated()) {
        }

		// Process grocery CRUD files if it has been rendered
		if (!empty($this->grocery_crud_content))
		{
			if (is_array($this->grocery_crud_content))
			{
				foreach($this->grocery_crud_content as $grocery_crud_content)
				{
					foreach ($grocery_crud_content->js_files as $file)
						$this->add_js_url($file);

					foreach ($grocery_crud_content->css_files as $file)
						$this->add_css_url($file);
				}
			}
			else
			{
				foreach ($this->grocery_crud_content->js_files as $file)
					$this->add_js_url($file);

				foreach ($this->grocery_crud_content->css_files as $file)
					$this->add_css_url($file);				
			}
		}
		
		// Get admin menu elements
		if ($this->session->is_authenticated() && $this->session->is_admin() && $template_name == 'admin')
		{
			$this->data_parts['menu_elements']		= $this->authentication->get_menu($this->session->get_user_id(), USER_TYPE_ADMIN);
			$this->data_parts['selected']			= $this->module_name;
		}

		// Load the template's parts
        $this->layout->load_view("templates/$template_name/header", array(
            'meta'=>  $this->meta,
			'title'=>  $this->title,
            'css_urls'=> $this->css_url,
            'css_scripts'=> $this->css_scripts,
            'js_urls'=> $this->js_url,
            'js_scripts'=> $this->js_scripts,
            'js_startup'=> $this->js_startup,
			'js_bottom'=> $this->js_bottom,
            'theme'=>  $this->theme
        ));
		
		$this->data_parts['is_authenticated']		= $this->session->is_authenticated();
		$this->data_parts['usertype']				= $this->session->get_usertype();
		$this->data_parts['userinfo']				= $this->session->get_user_info();
		
		$this->layout->load_view("templates/$template_name/header_menu", array('data_parts' => $this->data_parts));
		$this->layout->load_view("templates/$template_name/footer", array('data_parts' => $this->data_parts));

		$this->layout->set_part('data_parts', $this->data_parts);		
		$this->layout->set_part('content', $output);
		$this->layout->set_part('system_messages',  $this->get_formatted_system_messages());
        $this->layout->output();
    }
}