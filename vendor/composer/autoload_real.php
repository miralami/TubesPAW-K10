<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita3414c975aaa535d764cf88bd9b28bcc
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInita3414c975aaa535d764cf88bd9b28bcc', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita3414c975aaa535d764cf88bd9b28bcc', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita3414c975aaa535d764cf88bd9b28bcc::getInitializer($loader));

        $loader->register(true);

        $filesToLoad = \Composer\Autoload\ComposerStaticInita3414c975aaa535d764cf88bd9b28bcc::$files;
        $requireFile = \Closure::bind(static function ($fileIdentifier, $file) {
            if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
                $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

                require $file;
            }
        }, null, null);
        foreach ($filesToLoad as $fileIdentifier => $file) {
            $requireFile($fileIdentifier, $file);
        }

        return $loader;
    }
}
