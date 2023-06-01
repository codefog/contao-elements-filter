<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Doctrine\DBAL\Types\Types;

// Palettes
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'elementsFilter_enable';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['elementsFilter_enable'] = 'elementsFilter_handler,elementsFilter_filters';

PaletteManipulator::create()
    ->addLegend('elementsFilter_legend', 'syndication_legend', PaletteManipulator::POSITION_AFTER, true)
    ->addField('elementsFilter_enable', 'elementsFilter_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_article');

// Fields
$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_enable'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql' => "char(1) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_handler'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['default', 'isotope'],
    'reference' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_handlerRef'],
    'eval' => ['tl_class' => 'clr'],
    'sql' => ['type' => Types::STRING, 'length' => 8, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_filters'] = [
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'clr',
        'columnFields' => [
            'elementsFilter_filters_value' => [
                'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_value'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['rgxp' => 'alias', 'style' => 'width:200px;'],
            ],
            'elementsFilter_filters_label' => [
                'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_label'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['style' => 'width:200px;'],
            ],
            'elementsFilter_filters_cssClass' => [
                'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_cssClass'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['style' => 'width:150px;'],
            ],
            'elementsFilter_filters_group' => [
                'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_group'],
                'exclude' => true,
                'inputType' => 'checkbox',
            ],
        ],
    ],
    'sql' => ['type' => Types::BLOB, 'notnull' => false],
];
