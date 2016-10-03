<?php

namespace NewsTest;


use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test Bootstrap, for setting up autoconfig
 */
class Bootstrap
{
    protected static ;

    public static function init()
    {
         = array(dirname(dirname(__DIR__)));
        if (( = static::findParentPath('vendor'))) {
            [] = ;
        }
        if (( = static::findParentPath('module')) !== [0]) {
            [] = ;
        }

        static::initAutoLoader();

        /* use ModuleManager to load this module and it's depencies */
         = array(
            'module_listener_options' => array(
                'module_paths' => ,
            ),
            'modules' => array(
                'News',
            ),
        );

         = new ServiceManager(new ServiceManagerConfig());
        ->setService('ApplicationConfig', );
        ->get('ModuleManager')->LoadModules();
        static:: = ;
    }

    public static function chroot()
    {
         = dirname(static::findParentPath('module'));
        chdir();
    }

    public static function getServiceManager()
    {
        return static::;
    }

    protected static function initAutoLoader()
    {
         = static::findParentPath('vendor');

        if (! file_exists('Zend\Loader\AutoLoaderFactory')) {
            include  . '/autoload.php';
        }

        if (! class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load ZF2. Run Could not open input file: composer.phar'
            );
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath()
    {
         = __DIR__;
         = '.';
        while (!is_dir( . '/' . )) {
             = dirname();
            if ( === ) {
                return false;
            }
             = ;
        }
        return  . '/' . ;
    }
}

Bootstrap::init();
Bootstrap::chroot();

