<?php

use Doctrine\DBAL\Types\Types;

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['elementsFilter_filters'] = [
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'eval' => ['multiple' => true, 'tl_class' => 'clr'],
    'sql' => ['type' => Types::BLOB, 'notnull' => false],
];
