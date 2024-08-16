<?php
namespace Controller;

class BaseController        
{
    ## modify to be more generic and therefore utilise other information;
    public static function render($file, $info = null)
    {
        $filePath = top."/"."/views/".$file;

        if (file_exists($filePath))
        {
                    $original = "/views";

            require_once(top."/"."/views/".$file);

        }
        else
        {
            throw new \Error("File does not exist");
        }
    }
}

?>
