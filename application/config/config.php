<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for: URL
 * Here we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments (like WAMP, MAMP, etc.). Don't touch this unless you know what you do.
 *
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/application" or other folder inside your application or call any other .php file than index.php inside "/public".
 *
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do.
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mini');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

//define upload path
define('UPLOAD_PATH', 'img/');

/**
* configuration for cookies
*
*
*/

//1209600 = 2 weeks
define('COOKIE_RUNTIME', 1209600);
//IMPORTANT: always put a dot in front of the domain
define('COOKIE_DOMAIN', '.localhost');

/**
* configuration for hash
*
*
*/
define('HASH_COST_FACTOR', 10);

/**
* configuration for feedback messages
*
*
*/
define('FEEDBACK_USERNAME_FIELD_EMPTY','geen gebruikersnam ingevuld');
define('FEEDBACK_PASSWORD_FIELD_EMPTY','geen wachtwoord ingevuld');
define('FEEDBACK_LOGIN_FAILED','inloggen mislukt');
define('FEEDBACK_PASSWORD_WRONG_3_TIMES','3 maal fout wachtwoord wacht 30 seconden om het opnieuw te proberen');
define('FEEDBACK_PASSWORD_REPEAT_WRONG', 'password and password repeat are not the same');
define('FEEDBACK_PASSWORD_TOO_SHORT', 'password has a minimum lenght of 6 characters');
define('FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG', 'username can\'t be shorter than 2 characters or longer than 64 characters');
define('FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN', 'username does not fit the name scheme: only a-z A-Z 0-9');
define('FEEDBACK_EMAIL_FIELD_EMPTY', 'email not filled in');
define('FEEDBACK_EMAIL_TOO_LONG', 'email can\'t be longer than 64 characters');
define('FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN','email adress is not a valid email adress');
define('FEEDBACK_UNKNOW_ERROR', 'PANIEK!!! wtf is er aan de hand wij weten het ook niet');
define('FEEDBACK_USERNAME_ALREADY_TAKEN', 'gebruikersnaam bestaat al');
define('FEEDBACK_EMAIL_ALREADY_TAKEN', 'email bestaat al');
defien('FEEDBACK_ACCOUNT_CREATION_FAILED', 'aanmaken mislukt');
define('FEEDBACK_VERIFICATION_EMAIL_SENDING_FAILED', 'verificatie mail niet verzonden gebruiker niet gecreert');