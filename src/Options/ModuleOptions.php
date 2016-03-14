<?php
namespace Mte\DeepCopy\Options;

use Zend\Stdlib\AbstractOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ModuleOptions
 * @package Mte\StorageDocument\Options
 */
class ModuleOptions extends AbstractOptions implements FactoryInterface
{
    /**
     * Ключ конфигурации
     * @var string
     */
    private $configPrefix = 'mteDeepCopy';

    /**
     * @var array
     */
    protected $service;

    /**
     * @var array
     */
    protected $objectsCopyScheme;

    /**
     * Create service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array $config */
        $config = $serviceLocator->get('config');
        if (isset($config[$this->configPrefix]) && is_array($config[$this->configPrefix])) {
            $config = $config[$this->configPrefix];
        } else {
            $config = [];
        }
        return new ModuleOptions($config);
    }

    /**
     * @return array
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param array $service
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @param $serviceName
     * @return bool
     */
    public function getServiceParams($serviceName)
    {
        return isset($this->service[$serviceName]) ? $this->service[$serviceName] : false;
    }

    /**
     * @return array
     */
    public function getObjectsCopyScheme()
    {
        return $this->objectsCopyScheme;
    }

    /**
     * @param $objectsCopyScheme
     * @return $this
     */
    public function setObjectsCopyScheme($objectsCopyScheme)
    {
        $this->objectsCopyScheme = $objectsCopyScheme;
        return $this;
    }
}
