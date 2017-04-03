<?php
namespace App;

class Autoloader
{

    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Include the file needed for our class
     * @param $class string Le nom de la classe à charger
     */
    public static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__.'\\', '', $class);
        $class = str_replace('\\', '/', $class);
        require  $class . '.php';
    }
}

Autoloader::register();
