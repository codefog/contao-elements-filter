<?php

/**
 * Global callbacks
 */
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = [
    \Codefog\ElementsFilter\EventListener\ContentDataContainer::class,
    'adjustPalettes',
];

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['elementsFilter_filters'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['elementsFilter_filters'],
    'exclude'          => true,
    'inputType'        => 'checkbox',
    'options_callback' => [\Codefog\ElementsFilter\EventListener\ContentDataContainer::class, 'getFilters'],
    'eval'             => ['multiple' => true, 'tl_class' => 'clr'],
    'sql'              => "blob NULL",
];
