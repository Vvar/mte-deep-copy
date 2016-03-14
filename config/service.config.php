<?php
use Mte\MteDeepCopy\Service;

return [
    /**
     * Use: $this->getServiceLocator()->get('mteDeepCopy_Copy');
     */
    'Copy' => [
        'class' => Service\Copy::class,
        'options' => null,
    ],
];