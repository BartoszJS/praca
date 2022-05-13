<?php
define('APP_ROOT', dirname(__FILE__, 2));                // Root directory

require APP_ROOT . '/src/functions.php';                 // Functions
require APP_ROOT . '/config/config.php';                 // Configuration data
require APP_ROOT . '/vendor/autoload.php';               // Autoload libraries

if (DEV === false) {                                     // If not in development
    set_exception_handler('handle_exception');           // Set exception handler
    set_error_handler('handle_error');                   // Set error handler
    register_shutdown_function('handle_shutdown');       // Set shutdown handler
}

$cms = new \PhpBook\CMS\CMS($dsn, $username, $password); // Create CMS object
unset($dsn, $username, $password);                       // Remove database config data


 $session = $cms->getSession();                           
