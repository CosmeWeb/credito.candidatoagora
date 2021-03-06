<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Gettext library config
 * @package 	CodeIgniter\CI-Gettext
 * @category 	Configuration
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	http://www.bkader.com/
 */

/*
| -------------------------------------------------------------------
|  Enable/Disable Gettext Library
| -------------------------------------------------------------------
| Setting this to TRUE turns ON the use of gettext and makes your
| website multilingual. Which means that it will checks if current
| user's supported language is available and automatically sets the
| language in configuration.
| Setting this to FALSE will still let you use the Gettext library
| but the site will be in default language.
*/
$config['gettext_enabled'] = TRUE;

/*
| -------------------------------------------------------------------
|  Default Language
| -------------------------------------------------------------------
| Normally, you should set default language in config.php file but
| you can override this if you want.
| Set to NULL to use default one.
*/
$config['gettext_default'] = NULL;

/*
| -------------------------------------------------------------------
| Gettext default domain
| -------------------------------------------------------------------
| This allows you to set a custom domain to be used by gettext.
| Gettext *.MO files are located inside LC_MESSAGES folder like so:
| English: ./application/language/english/LC_MESSAGES/{$domain}.mo
| French: ./application/language/french/LC_MESSAGES/{$domain}.mo
|
| Note: by default, gettext_domain is set to 'messages' if this
| option is set to NULL below
*/
$config['gettext_domain'] = NULL;

/*
| -------------------------------------------------------------------
|  Site languages
| -------------------------------------------------------------------
| A list of enabled languages. These are the language that will be
| used on the site.
*/
$config['gettext_languages'] = array('english', 'french', 'arabic','german', 'italian', 'portugues', 'spanish');

/*
| -------------------------------------------------------------------
|  Gettext library Session & Cookie use
| -------------------------------------------------------------------
| If one of these configurations is enabled, the language name (folder
| name) will be stored in whether a session or a cookie BUT NOT BOTH
| You must know that only one is allowed, session OR cookie. If both
| are enabled, COOKIES are privileged.
*/
$config['gettext_session'] = NULL;
$config['gettext_cookie']  = 'lang';

/*
| -------------------------------------------------------------------
|  All available languages
| -------------------------------------------------------------------
| You can add as many as you want. If you can add all world languages
| be free to do it :) .. This is the array that contains languages
| details. Make sure languages used in $config['gettext_languages']
| exists in this array.
*/
$config['available_languages'] = array(

	// English
	'english' => array(
		'name'      => 'English',
		'name_en'   => 'English',
		'folder'    => 'english',
		'direction' => 'ltr',
		'code'      => 'en',
		'flag'      => 'us',
	),

	// French
	'french' => array(
		'name'      => 'Fran??ais',
		'name_en'   => 'French',
		'folder'    => 'french',
		'direction' => 'ltr',
		'code'      => 'fr',
		'flag'      => 'fr',
	),

	// Arabic
	'arabic' => array(
		'name'      => '??????????????',
		'name_en'   => 'Arabic',
		'folder'    => 'arabic',
		'direction' => 'rtl',
		'code'      => 'ar',
		'flag'      => 'dz',
	),
	// German
	'german' => array(
		'name'      => 'German',
		'name_en'   => 'German',
		'folder'    => 'german',
		'direction' => 'ltr',
		'code'      => 'de',
		'flag'      => 'de',
	),// Italian
	'italian' => array(
		'name'      => 'Italian',
		'name_en'   => 'Italian',
		'folder'    => 'italian',
		'direction' => 'ltr',
		'code'      => 'it',
		'flag'      => 'it',
	),// French
	'portugues' => array(
		'name'      => 'Portugu??s',
		'name_en'   => 'Portugues',
		'folder'    => 'portugues',
		'direction' => 'ltr',
		'code'      => 'pt-br',
		'flag'      => 'pt-br',
	),// French
	'spanish' => array(
		'name'      => 'Spanish',
		'name_en'   => 'Spanish',
		'folder'    => 'spanish',
		'direction' => 'ltr',
		'code'      => 'es',
		'flag'      => 'es',
	),

);

/* End of file gettext.php */
/* Location: ./application/config/gettext.php */