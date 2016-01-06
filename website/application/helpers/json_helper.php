<?php

function sendJson($data, $callback = NULL) {
    $CI =& get_instance();
    $CI->output->set_content_type('application/json');
    $json = json_encode($data);
    $json = $callback !== null ? $callback . '('.$json.');' : $json;
    $CI->output->set_output($json);
    return $json;
}