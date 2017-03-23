<?php

namespace ElementsFilter\EventListener;

use ElementsFilter\FilterHelper;

class ContentDataContainer
{
    /**
     * Adjust the palettes
     */
    public function adjustPalettes()
    {
        if (!FilterHelper::isArticleEnabled(CURRENT_ID)) {
            return;
        }

        foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k => $v) {
            if (is_array($v)) {
                continue;
            }

            $GLOBALS['TL_DCA']['tl_content']['palettes'][$k] = str_replace(
                'protected;',
                'protected;{elementsFilter_legend},elementsFilter_filter;',
                $v
            );
        }
    }

    /**
     * Get the filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = [];

        foreach (FilterHelper::getArticleFilters(CURRENT_ID) as $filter) {
            if ($filter['value']) {
                $filters[$filter['value']] = $filter['label'];
            }
        }

        return $filters;
    }
}
