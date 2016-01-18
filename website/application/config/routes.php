<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "client";
$route['404_override'] = '';

$route['acerca_de'] = "client/about_us";
$route['calendario'] = "client/under_construction";
$route['biblioteca'] = "client/under_construction";

$route['diputados'] = "client/congressman";
$route['diputado/(:num)'] = "client/congressman/congressman_profile/$1";
$route['diputado/votaciones/(:num)'] = "client/congressman/congressman_votes/$1";
$route['diputado/asistencia/(:num)'] = "client/congressman/congressman_attendance/$1";
$route['diputado/bancadas/(:num)'] = "client/congressman/congressman_parties/$1";
$route['diputado/leyes_presentadas/(:num)'] = "client/congressman/congressman_laws/$1";
$route['diputado/citaciones/(:num)'] = "client/congressman/congressman_citations/$1";
$route['diputado/comisiones/(:num)'] = "client/congressman/congressman_comissions/$1";
$route['diputado/cv/(:num)'] = "client/congressman/congressman_cv/$1";

$route['actividades_legislativas'] = "client/law";
$route['actividad_legislativa/(:num)'] = "client/law/law_profile/$1";
$route['actividad_legislativa/votaciones/(:num)'] = "client/law/law_votes/$1";
$route['actividad_legislativa/dictamenes/(:num)'] = "client/law/law_rulings/$1";
$route['actividad_legislativa/historial/(:num)'] = "client/law/law_timeline/$1";

$route['comisiones'] = "client/commission";
$route['comision/(:num)'] = "client/commission/commission_profile/$1";

$route['admin'] = "admin/admin";
$route['admin'] = "admin/admin";
$route['admin/login'] = "admin/admin/login";
$route['admin/no_access'] = "admin/admin/no_access";

/* End of file routes.php */
/* Location: ./application/config/routes.php */