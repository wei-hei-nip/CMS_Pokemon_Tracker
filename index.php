<?php


// Callback for autoloading controllers and models
function autoloadFunction($class) {
    // Replace backslashes \ and slashes / with the directory separator (pre-defined constant) for our operating system
    $class = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $class);
    /* If the class name ends with the string 'Controller' require the PHP file from the /controllers folder.
     * In any other case, require PHP files from the /models folder. */
    if (preg_match('/Controller$/', $class)) {
        require_once('controllers/' . $class . '.php');
    }
    else {
        require_once('models/' . $class . '.php');
    }
}

// Create a function to handle session errors (try/catch does not work for sessions)
function session_error_handling() {
    die('PHP session management is not working correctly. Check the error log.');
}

// Start session management
set_error_handler('session_error_handling');
session_start();
restore_error_handler();

// Registers the callback
spl_autoload_register('autoloadFunction');

/* Define configuration constants containing the paths we will be working with.
 * Constants cannot be changed during runtime and should only be used scarcely.
 * BASE_PATH: This is our base URI path (.e.g /~username/cms)
 */
$base_path = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_PATH', $base_path);

// Connects to the database
Db::connect( null, null, 'uczcwni');

// Create the router and process parameters for the requested URL
$router = new RouterController();
$router->process(array('url' => $_SERVER['REQUEST_URI']));

// Render the view
$router->renderView();