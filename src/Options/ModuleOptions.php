<?php
namespace Mte\MteDeepCopy\Options;

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
    private $configPrefix = 'storageDocument';

    /**
     * @var array
     */
    protected $repositories;

    /**
     * @var array
     */
    protected $service;

    /**
     * @var array
     */
    protected $hydrator;

    /**
     * @return array
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param array $hydrator
     * @return $this
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    public function getHydratorParams($hydratorName)
    {
        return isset($this->hydrator[$hydratorName]) ? $this->hydrator[$hydratorName] : false;
    }

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
    public function getRepositories()
    {
        return $this->repositories;
    }

    /**
     * @param $repositories
     * @return $this
     */
    public function setRepositories($repositories)
    {
        $this->repositories = $repositories;
        return $this;
    }

    /**
     * @param $repositoriesName
     * @return bool
     */
    public function getRepositoriesParams($repositoriesName)
    {
        return isset($this->repositories[$repositoriesName]) ? $this->repositories[$repositoriesName] : false;
    }
}
