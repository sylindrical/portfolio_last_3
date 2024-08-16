<?php


function autoload($name)
{

    $class_path = str_replace('\\', '/', $name);
    
    $file =  __DIR__ . '/' . $class_path . '.php';


    if (file_exists($file))
    {
        require($file);
    }
}

?>