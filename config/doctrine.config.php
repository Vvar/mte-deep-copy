<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Roman Malashin <malashinr@mte-telecom.ru>
 */
return [
    'doctrine' => [
        'driver' => [
            'MteStorageDocumentEntity' => [
                'paths' => [__DIR__ . '/../src/Entity'],
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver'
            ]
        ]
    ]
];