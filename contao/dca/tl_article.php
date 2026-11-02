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
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql' => ['type' => Types::BOOLEAN, 'default' => 0],
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_handler'] = [
    'inputType' => 'select',
    'options' => ['default', 'isotope'],
    'reference' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_handlerRef'],
    'eval' => ['tl_class' => 'clr'],
    'sql' => ['type' => Types::STRING, 'length' => 8, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_article']['fields']['elementsFilter_filters'] = [
    'inputType' => 'rowWizard',
    'fields' => [
        'value' => [
            'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_value'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'alias'],
        ],
        'label' => [
            'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_label'],
            'inputType' => 'text',
        ],
        'cssClass' => [
            'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_cssClass'],
            'inputType' => 'text',
        ],
        'group' => [
            'label' => &$GLOBALS['TL_LANG']['tl_article']['elementsFilter_filters_group'],
            'inputType' => 'checkbox',
        ],
    ],
    'eval' => ['mandatory' => true, 'tl_class' => 'w50 clr'],
    'sql' => ['type' => Types::BLOB, 'notnull' => false],
];
