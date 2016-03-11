<?php
namespace Mte\MteDeepCopy\Service;

use DeepCopy\Filter\Filter;
use DeepCopy\DeepCopy;
use DeepCopy\Matcher\Matcher;
use DeepCopy\Filter\Doctrine\DoctrineCollectionFilter;
use DeepCopy\Filter\Doctrine\DoctrineEmptyCollectionFilter;
use DeepCopy\Filter\SetNullFilter;
use DeepCopy\Filter\KeepFilter;
use DeepCopy\Matcher\PropertyTypeMatcher;
use DeepCopy\Matcher\PropertyNameMatcher;
use DeepCopy\Matcher\PropertyMatcher;
use Mte\MteDeepCopy\Options\ModuleOptions;
use ReflectionClass;
use Zend\Stdlib\InitializableInterface;


/**
 * Class CloneObject
 * @package Mte\TargetedInvestmentProgram\Grid
 */
class Copy extends AbstractService implements InitializableInterface
{

    /**
     * Объект DeepCopy
     * @var DeepCopy
     */
    protected $deepCopy;

    /**
     * @return DeepCopy
     */
    public function getDeepCopy()
    {
        return $this->deepCopy;
    }

    /**
     * @param DeepCopy $deepCopy
     */
    public function setDeepCopy($deepCopy)
    {
        $this->deepCopy = $deepCopy;
    }


    /**
     * Init an object
     *
     * @return void
     */
    public function init()
    {
        $deepCopy = new DeepCopy();
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $this->getServiceManager()->get(ModuleOptions::class);
        $objectsCopyScheme = $moduleOptions->getObjectsCopyScheme();

        foreach ($objectsCopyScheme as $objectCopyScheme ) {
            if (is_array($objectCopyScheme)) {
                foreach($objectCopyScheme as $params) {
                    $this->addFilter($deepCopy, $params);
                }
            }
        }
        $this->setDeepCopy($deepCopy);
    }

    /**
     * @param object $object
     * @return mixed
     */
    public function cloneObject($object)
    {
        if (!is_object($object)) {
            throw new \RuntimeException('Не верный тип параметра');
        }

        return $this->getDeepCopy()->copy($object);
    }

    /**
     * @param DeepCopy $deepCopy
     * @param array $params
     */
    protected function addFilter(DeepCopy $deepCopy, $params)
    {
        $filter = null;
        if (!empty($params['filter'])) {
            if (is_array($params['filter']) && is_string($params['filter']['class'])) {
                $reflection = new ReflectionClass($params['filter']['class']);
                if (!$reflection->isInstantiable()){
                    throw new \RuntimeException('Невозможно создать экземпляр класса');
                }
                if (!$reflection->implementsInterface(Filter::class)) {
                    throw new \RuntimeException('Filter должен реализовывать ' . Filter::class);
                }

                if (array_key_exists('options', $params['filter'])
                    && is_array($params['filter']['options'])
                    && !empty($params['filter']['options'])
                ) {
                    $filter = $reflection->newInstanceArgs($params['filter']['options']);
                } else {
                    $filter = $reflection->newInstanceWithoutConstructor();
                }
            } elseif (is_object($params['filter'])) {
                $filter = $params['filter'];
            }
        }

        $matcher = null;
        if (array_key_exists('matcher', $params) && $params['matcher']) {
            if (is_array($params['matcher'])
                && array_key_exists('class', $params['matcher'])
                && is_string($params['matcher']['class'])
                && array_key_exists('options', $params['matcher'])
                && is_array($params['matcher']['options'])
            ) {
                $reflection = new ReflectionClass($params['matcher']['class']);
                if (!$reflection->isInstantiable()){
                    throw new \RuntimeException('Невозможно создать экземпляр класса');
                }
                if (!$reflection->implementsInterface(Matcher::class)) {
                    throw new \RuntimeException('Matcher должен реализовывать ' . Matcher::class);
                }
                $matcher = $reflection->newInstanceArgs($params['matcher']['options']);

            } elseif (is_object($params['matcher'])
                && array_key_exists(Matcher::class, class_implements($params['matcher']))
            ) {
                $matcher = $params['matcher'];
            }
        }

        if ($matcher instanceof Matcher && $filter instanceof Filter) {
            $deepCopy->addFilter($filter, $matcher);
        }
    }
}