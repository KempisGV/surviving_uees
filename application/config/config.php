<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

ini_set('session.cookie_httponly', 1);

return array(
	'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public_html', '', dirname($_SERVER['SCRIPT_NAME'])),
	'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controller/',
	'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/view/',
	'DEFAULT_CONTROLLER' => 'public',
	'DEFAULT_ACTION' => 'index',

	'DB_TYPE' => 'mysql',
	'DB_HOST' => '127.0.0.1',
	'DB_NAME' => 'surviving_uees',
	'DB_USER' => 'root',
	'DB_PASS' => '',
	'DB_PORT' => '3306',
	'DB_CHARSET' => 'utf8',

	'COOKIE_RUNTIME' => 1209600,
	'COOKIE_PATH' => '/',
	'COOKIE_DOMAIN' => "",
	'COOKIE_SECURE' => false,
	'COOKIE_HTTP' => true,
	'SESSION_RUNTIME' => 604800,

	'ENCRYPTION_KEY' => '6#x0gÊìf^25cL1f$08&',
	'HMAC_SALT' => '8qk9c^4L6d#15tM8z7n0%',

	'EMAIL_USED_MAILER' => 'phpmailer',
    'EMAIL_USE_SMTP' => true,
    'EMAIL_SMTP_HOST' => 'smtp.gmail.com',
    'EMAIL_SMTP_AUTH' => true,
    'EMAIL_SMTP_USERNAME' => 'survivinguees@gmail.com',
    'EMAIL_SMTP_PASSWORD' => 'Pruebas00',
    'EMAIL_SMTP_PORT' => 465,
    'EMAIL_SMTP_ENCRYPTION' => 'ssl',

    'EMAIL_ADMIN' => 'survivinguees@gmail.com',
	'EMAIL_ADMIN_NAME' => 'Surviving UEES Admin',

	'EMAIL_VERIFICATION_CONTENT' => 'Bienvenido a Surviving UEES, para activar tu cuenta con nosotros haz click ',
	'EMAIL_VERIFICATION_URL'=> 'register/verify',
	'EMAIL_VERIFICATION_FROM_EMAIL' => 'survivinguees@gmail.com',
	'EMAIL_VERIFICATION_FROM_NAME' => 'Surviving UEES',
	'EMAIL_VERIFICATION_SUBJECT'=> 'Surviving UEES: Activación de Cuenta',

	'EMAIL_PASSWORD_RESET_CONTENT' => "Haz solicitado un reinicio de contraseña, para restablecer tu cuenta con nosotros haz click ",
	'EMAIL_PASSWORD_RESET_URL' => 'login/resetPassword',
	'EMAIL_PASSWORD_RESET_FROM_EMAIL' => 'survivinguees@gmail.com',
	'EMAIL_PASSWORD_RESET_FROM_NAME' => 'Surviving UEES',
	'EMAIL_PASSWORD_RESET_SUBJECT' => 'Surviving UEES: Reinicio de Contraseña',

	'CITIES' => array(
		1 => 'Samborondon',
		2 => 'Guayaquil',
		3 => 'Daule',
		4 => 'Duran',
	),
	'SECTOR' => array(
		1 => 'Puntilla',
		2 => 'Samborondon',
		3 => 'Tarifa',
		
	),
	'WORKAREAS' => array(
		1 => 'Workarea1',
		2 => 'Workarea2'
	),
	'BENEFITS' => array(
		1 => 'Benefit1',
		2 => 'Benefit2'
	)
);