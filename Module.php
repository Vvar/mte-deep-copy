<?php
namespace Mte\MteDeepCopy;

use DeepCopy\DeepCopy;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Mte\DeepCopy\Options\ModuleOptions;
use Mte\DeepCopy\Service\Factory;

/**
 * Class Module
 * @package Mte\MteDeepCopy
 */
class Module
{

    public function init() {

    }

    /** @var  ServiceLocatorInterface */
    protected static $modelManager = null;

    public function onBootstrap(MvcEvent $event)
    {
        self::$modelManager = $event->getApplication()->getServiceManager();
    }
    /**
     * @return ServiceLocatorInterface
     */
    public static function getModelManager()
    {
        return self::$modelManager;
    }
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        $config = [];
        $autoloadFile = __DIR__ . '/autoload_classmap.php';
        if (file_exists($autoloadFile)) {
            $config['Zend\Loader\ClassMapAutoloader'] = [
                $autoloadFile,
            ];
        }
        $config['Zend\Loader\StandardAutoloader'] = [
            'namespaces' => [
                __NAMESPACE__ => __DIR__ . '/src',
            ],
        ];
        return $config;
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to seed
     * such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerConfig()
    {
        return [
            'invokables' => [

            ]

        ];
    }
    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'mteDeepCopyOptions' => ModuleOptions::class,
            ],
            'factories' => [
                ModuleOptions::class => ModuleOptions::class,
            ],
            'abstract_factories' => [
                Factory::class
            ],
            'invokables' => [
                'deepCopy' => DeepCopy::class
            ]
        ];
    }
}