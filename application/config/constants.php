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
| Facebook constants
|--------------------------------------------------------------------------

|
*/

define('APP_URL_CANVAS', 'http://apps.facebook.com/swisstv_dev/');
define('APP_URL_SERVER', 'http://swisstv.bigbang-interactive.com/index.php/start/app_access/');
define('APP_ID', '198131270224876');
define('APP_KEY', '159139e0140b688e2f1efdeb36736a7f');
define('SECRET_KEY', '4a1083c192b2486ab06be8833dde72b8');
define('FACEBOOK_DOMAIN', 'bigbang-interactive.com');
define('PAGE_FAN_URL', 'http://www.facebook.com/LionelWebDevelopper');
define('PAGE_FAN_APP_URL', 'http://www.facebook.com/LionelWebDevelopper?sk=app_198131270224876');
//Same name than the directory (ex: eng or fr)
define('LANGUAGE', 'fr');

/* End of file constants.php */
/* Location: ./application/config/constants.php */