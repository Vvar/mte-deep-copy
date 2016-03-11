<?php
namespace Mte\MteDeepCopy\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractFactory
 * @package Mte\MteDeepCopy\Service
 */
class AbstractFactory implements AbstractFactoryInterface
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

        /** @var \Mte\StorageDocument\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Mte\MteDeepCopy\Options\Module');
        $serviceOptions = $moduleOptions->getServiceParams($className);

        if (!is_array($serviceOptions)) {
            throw new \Exception("Service {$className} does not found.");
        }

        $serviceClass = isset($serviceOptions['class']) ? $serviceOptions['class'] : null;
        $serviceOptions = isset($serviceOptions['options']) ? $serviceOptions['options'] : null;

        $service = new $serviceClass (
            $serviceOptions
        );

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
