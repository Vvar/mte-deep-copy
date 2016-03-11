<?php
use \Mte\StorageDocument\Service;

return [
    /**
     * Default Okei Mapper
     * Use: $this->getServiceLocator()->get('mteDeepCopy_DeepCopy');
     */
    'DeepCopy' => [
        'class' => Service\Document::class,
        'options' => null,
    ],
];