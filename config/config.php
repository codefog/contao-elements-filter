<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate'][] = ['ElementsFilter\EventListener\TemplateListener', 'onParseTemplate'];
