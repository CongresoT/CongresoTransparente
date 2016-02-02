<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| User type
|--------------------------------------------------------------------------
|
| These are the user types
|
*/

define('USER_TYPE_ADMIN',		'1');
define('USER_TYPE_FRONT',		'2');

/*
|--------------------------------------------------------------------------
| Content constants
|--------------------------------------------------------------------------
|
| These are content constants
|
*/

define('CONTENT_ABOUT_US',				'1');
define('CONTENT_FRONTPAGE_TEXT',		'2');
define('CONTENT_FRONTPAGE_AD',			'3');
define('CONTENT_UNDER_CONSTRUCTION',	'4');

/*
|--------------------------------------------------------------------------
| Site Constants
|--------------------------------------------------------------------------
|
| These are the user types
|
*/

define('DEFAULT_SITE_TITLE',		'Congreso Transparente');
define('DEFAULT_SITE_DESCRIPTION',		'Congreso Transparente');
define('DEFAULT_SITE_KEYWORDS',		'congreso, transparente');

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
|
| These are the user types
|
*/
define('SALT',		'FR3EQ3NT');
//define('SALT',		'U3ML0G05M3D');


/*
|--------------------------------------------------------------------------
| System messages constants
|--------------------------------------------------------------------------
|
| These are the system messages constants
|
*/
define('SYS_MSG_STYLE_SUCCESS', 1);
define('SYS_MSG_STYLE_INFO', 2);
define('SYS_MSG_STYLE_WARNING', 3);
define('SYS_MSG_STYLE_ERROR', 4);

/*
|--------------------------------------------------------------------------
| Sex ID
|--------------------------------------------------------------------------
|
| Sexes IDs
|
*/
define('SEX_ID_FEMALE', 1);
define('SEX_ID_MALE', 2);

/*
|--------------------------------------------------------------------------
| Vote Results ID
|--------------------------------------------------------------------------
|
| These are IDs of client's site main content
|
*/
define('VOTE_RESULT_ID_YES', 1);
define('VOTE_RESULT_ID_NO', 2);
define('VOTE_RESULT_ID_NONE', 3);

/*
|--------------------------------------------------------------------------
| Attendance ID
|--------------------------------------------------------------------------
|
| These are IDs of client's site main content
|
*/
define('ATTENDANCE_STATE_ID_YES', 1);
define('ATTENDANCE_STATE_ID_NO', 2);
define('ATTENDANCE_STATE_ID_NO_JUSTIFIED', 3);
define('ATTENDANCE_STATE_ID_NONE', 4);

/*
|--------------------------------------------------------------------------
| App Version constant
|--------------------------------------------------------------------------
|
| These are IDs of client's site main content
|
*/
define('APP_VERSION', '1.0.1.2');

/* End of file constants.php */
/* Location: ./application/config/constants.php */