<?php
use DeepCopy\Filter\Doctrine\DoctrineCollectionFilter;
use DeepCopy\Filter\ReplaceFilter;
use DeepCopy\Filter\KeepFilter;
use DeepCopy\Matcher\PropertyTypeMatcher;
use DeepCopy\Matcher\PropertyNameMatcher;
use DeepCopy\Matcher\PropertyMatcher;

return [
    'ProjectPrototype' => [
        'class' => Mte\TargetedInvestmentProgram\Entity\Project\Prototype::class,
        'options' => [
            [
                'filter' => [
                    'class' => DoctrineCollectionFilter::class,
                    'options' => []
                ],
                'matcher' => [
                    'class' => PropertyTypeMatcher::class,
                    'options' => [
                        'objectClass' => 'Doctrine\Common\Collections\Collection',
                    ]
                ],
            ],

            [
                'filter' => new KeepFilter(),
                'matcher' => new PropertyMatcher(Mte\TargetedInvestmentProgram\Entity\Project\Prototype::class, 'status'),
            ],
            [
                'filter' => [
                    'class' => KeepFilter::class,
                    'options' => []
                ],
                'matcher' => [
                    'class' => PropertyMatcher::class,
                    'options' => [
                        'objectClass' => Mte\TargetedInvestmentProgram\Entity\Project\Prototype::class,
                        'property' => 'parent',
                    ]
                ],
            ],
            [
                'filter' => new KeepFilter(),
                'matcher' => new PropertyMatcher(Mte\TargetedInvestmentProgram\Entity\Activity\Prototype::class, 'object'),
            ],
            [
                'filter' => new KeepFilter(),
                'matcher' => new PropertyNameMatcher('customer'),
            ],
            [
                'filter' => [
                    'class' => KeepFilter::class,
                    'options' => []
                ],
                'matcher' => [
                    'class' => PropertyNameMatcher::class,
                    'options' => [
                        'property' => 'category',
                    ]
                ],
            ],
            [
                'filter' => new KeepFilter(),
                'matcher' => new PropertyNameMatcher('areaSpb'),
            ],
            [
                'filter' => new KeepFilter(),
                'matcher' => new PropertyNameMatcher('typeWork'),
            ],

            [
                'filter' => [
                    'class' => ReplaceFilter::class,
                    'options' => [
                        'callback' => function ($currentValue) {return $currentValue . ' (copy)';},
                    ],
                ],
                'matcher' => [
                    'class' => PropertyMatcher::class,
                    'options' => [
                        'objectClass' => Mte\TargetedInvestmentProgram\Entity\Project\Prototype::class,
                        'property' => 'title',
                    ],
                ],
            ],
        ]
    ],
];