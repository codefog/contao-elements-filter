<?php

namespace Codefog\ElementsFilter\EventListener;

use Contao\Template;
use Codefog\ElementsFilter\FilterHelper;

class TemplateListener
{
    /**
     * On parse the template
     *
     * @param Template $template
     */
    public function onParseTemplate(Template $template)
    {
        $this->handleArticleTemplate($template);
        $this->handleElementTemplate($template);
    }

    /**
     * Handle the article template
     *
     * @param Template $template
     */
    private function handleArticleTemplate(Template $template)
    {
        if (TL_MODE !== 'FE'
            || stripos($template->getName(), 'mod_article') !== 0
            || $template->customTpl
            || !FilterHelper::isArticleEnabled($template->id)
        ) {
            return;
        }

        $template->setName('mod_article_elements_filter');
        $template->elementsFilters        = FilterHelper::getArticleFilters($template->id);
        $template->elementsFiltersHandler = $template->elementsFilter_handler;

        // Add the handler assets
        if (($assets = FilterHelper::getHandlerAssets($template->id)) !== null) {
            foreach ($assets as $asset) {
                $GLOBALS['TL_JAVASCRIPT'][] = $asset;
            }
        }
    }

    /**
     * Handle the content element template
     *
     * @param Template $template
     */
    private function handleElementTemplate(Template $template)
    {
        if (TL_MODE !== 'FE'
            || (stripos($template->getName(), 'ce_') !== 0 && stripos($template->getName(), 'rsce_') !== 0)
            || !FilterHelper::isArticleEnabled($template->pid)
            || count(($filters = deserialize($template->elementsFilter_filters, true))) < 1
        ) {
            return;
        }

        $classes = [];

        foreach ($filters as $filter) {
            $classes[] = 'elements-filter-'.$filter;
        }

        $template->class = trim($template->class.' elements-filter '.implode(' ', $classes));
    }
}
