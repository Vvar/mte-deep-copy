<?php
namespace Mte\DeepCopy\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Mte\DeepCopy\Options\ModuleOptions;

/**
 * Class AbstractFactory
 * @package Mte\MteDeepCopy\Service
 */
class Factory implements AbstractFactoryInterface
{
    /**
     * Алиас
     * @var string
     */
    protected $alias = 'mteDeepCopy';

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        if (isset($options['alias']) && is_string($options['alias'])) {
            $this->setAlias($options['alias']);
        }
    }

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, $this->getAlias() . '_') === 0;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     * @throws \Exception
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $className = str_replace($this->getAlias() . '_', '', $requestedName);
        /** @var \Mte\MteDeepCopy\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);
        $serviceOptions = $moduleOptions->getServiceParams($className);

        if (!is_array($serviceOptions)) {
            throw new \Exception("Service {$className} does not found.");
        }

        $serviceClass = isset($serviceOptions['class']) ? $serviceOptions['class'] : null;
        $serviceOptions = isset($serviceOptions['options']) ? $serviceOptions['options'] : null;

        /** @var Copy $service */
        $service = new $serviceClass (
            $serviceOptions
        );

        $service->setServiceManager($serviceLocator);
        $service->init();

        return $service;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
}
