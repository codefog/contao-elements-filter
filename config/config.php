<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate'][] = [\Codefog\ElementsFilter\EventListener\TemplateListener::class, 'onParseTemplate'];
