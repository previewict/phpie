<?php

/**
 *
 * @author Shaharia Azam
 *
 */

namespace Phpie\Autoload;

class Autoload
{
    /**
     * @var array
     */
    protected static $loaded = array();

    /**
     * @var array
     */
    protected static $namespaces = array();

    /**
     * @param array $namespaces
     */
    public static function register($namespaces = array())
    {
        $registered = spl_autoload_register(array('\\' . __NAMESPACE__ . '\Autoload', 'loadClass'));

        foreach ($namespaces as $namespace => $path) {
            self::registerNamespace($namespace, $path);
        }
    }

    /**
     * @param $namespace
     * @param $path
     */
    protected static function registerNamespace($namespace, $path)
    {
        self::$namespaces[$namespace] = $path;
    }

    /**
     * @param $class
     */
    protected static function loadClass($class)
    {
        // Checking if the class was already loaded or not
        if (!isset(self::$loaded[$class])) {
            // Getting the namespace of the class
            $namespace = current(explode('\\', $class));


            // Building the filepath
            $file = self::$namespaces[$namespace] . DIRECTORY_SEPARATOR . str_replace(
                    '\\',
                    DIRECTORY_SEPARATOR,
                    $class
                ) . '.php';

            // Checking if a file exists for the requested class
            if (is_file($file)) {
                // Adding the file to the loaded array
                self::$loaded[$class] = $file;

                // Loading the file
                include $file;
            }
        }
    }
}