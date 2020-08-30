<?php

// Database params
$db['db_host'] = 'localhost';
$db['db_user'] = 'root'; 
$db['db_pass'] = ''; 
$db['db_name'] = 'test';

// Make databas params as constants
foreach($db as $key => $value){
    define(strtoupper($key),$value);
}


// Application root directory
define('APP_ROOT',dirname(dirname(__FILE__)));

define('URL_ROOT','http://localhost/jump');

// Site Name
define('SITE_NAME','Jump');
