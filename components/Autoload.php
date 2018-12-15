<?php

/**
 * Function __autoload for auto loading of classes 
 */
function __autoload($class_name)
{
    // array of folders where is could be classes 
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    // iterate over arrays of folders
    foreach ($array_paths as $path) {

        // make name and path to file with class
        $path = ROOT . $path . $class_name . '.php';

        // If such a file exists, connect it
        if (is_file($path)) {
            include_once $path;
        }
    }
}
