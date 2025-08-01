<?php
defined('BASEPATH') OR exit('No direct script access allowed');

################## PRODUCTION ###########################
$active_group = 'default';
$query_builder = TRUE;

$subdomain_db = str_replace(".ezsellbd.com","",$_SERVER['HTTP_HOST']);

$db['default'] = array(
	'dsn'	=> 'mysql:host=ezselldbserver-do-user-18659108-0.m.db.ondigitalocean.com;port=25060;dbname=pos_'.$subdomain_db.';charset=utf8',
	'hostname' => '',
	'username' => 'appuser',
	'password' => 'AVNS_fxp5nuUMiedMww35Bdc',
	'database' => 'pos_'.$subdomain_db,
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_unicode_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	//'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port'=>25060
);
