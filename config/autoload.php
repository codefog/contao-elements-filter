<?php

/**
 * Register PSR-0 namespace
 */
if (class_exists('NamespaceClassLoader')) {
    NamespaceClassLoader::add('ElementsFilter', 'system/modules/elements-filter/src');
}

/**
 * Register the templates
 */
TemplateLoader::addFiles(
    [
        'mod_article_elements_filter' => 'system/modules/elements-filter/templates/modules',
    ]
);
