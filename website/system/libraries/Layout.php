<?php

class Layout {

    private $template_name;
    private $CI;
    private $parts;
    private $config;

    function __construct($template_name = NULL) {
        $this->CI = & get_instance();
        $this->config = config_item('layout');
        if ($this->template_name === NULL)
            $this->template_name = $this->config['template_name'];
        if ($this->template_name === NULL)
            show_404();
        $this->parts = array();
    }

    function set_template($template_name) {
        $this->template_name = $template_name;
    }

    function get_template() {
        return $this->template_name;
    }

    function load_view($name, $data = NULL, $alt_name = NULL) {
        $path = $name;
        if (empty($alt_name)) {
            $nameparts = explode('/', $path);
            $name = $nameparts[count($nameparts)-1];
        }
        else $name = $alt_name;
        $this->parts[$name] =
                $this->CI->load->view($path, $data, TRUE);
    }

    function set_parts($parts) {
        foreach ($parts as $name=>$content) {
            $this->parts[$name] = $content;
        }
    }

    function set_part($name, $content) {
        $this->parts[$name] = $content;

    }

    function output() {
		global $BM;

        $output	= $this->CI->load->view("templates/{$this->template_name}/template", $this->parts, TRUE);
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';

		$output = str_replace('{elapsed_time}', $elapsed, $output);
		$output = str_replace('{memory_usage}', $memory, $output);

		echo $output;
    }

}