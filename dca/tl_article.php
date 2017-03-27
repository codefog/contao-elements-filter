<?php

/**
 * Extend palettes
 */
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'elementsFilter_enable';
$GLOBALS['TL_DCA']['tl_article']['palettes']['default']        = str_replace(
    'printable;',
    'printable;{elementsFilter_legend:hide},elementsFilter_enable;',
    $GLOBALS['TL_DCA']['tl_article']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_article']['subpalettes']['elementsFilter_enable'] = 'elementsFilter_handler,elementsFilter_filters';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_enable'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_enable'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_handler'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_handler'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => ['default', 'isotope'],
    'reference' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_handlerRef'],
    'eval'      => ['tl_class' => 'clr'],
    'sql'       => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_filters'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters'],
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'mandatory'    => true,
        'tl_class'     => 'clr',
        'columnFields' => [
            'elementsFilter_filters_value'    => [
                'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_value'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => ['rgxp' => 'alias', 'style' => 'width:200px;'],
            ],
            'elementsFilter_filters_label'    => [
                'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_label'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => ['style' => 'width:200px;'],
            ],
            'elementsFilter_filters_cssClass' => [
                'label'     => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_cssClass'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => ['style' => 'width:150px;'],
            ],
        ],
    ],
    'sql'       => "blob NULL",
];
