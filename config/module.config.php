<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Roman Malashin <malashinr@mte-telecom.ru>
 */

$doctrineConfig = include 'doctrine.config.php';
return array_merge(
    $doctrineConfig,
    [
        'mteDeepCopy' => [
            'service' => require 'service.config.php',
            'objectsCopyScheme' => require 'objectsCopyScheme.config.php',
        ],
]);