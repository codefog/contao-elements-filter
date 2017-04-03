<?php

namespace Codefog\ElementsFilter;

use Contao\Database;

class FilterHelper
{
    /**
     * Return true if article is enabled for elements filter
     *
     * @param int $articleId
     *
     * @return bool
     */
    public static function isArticleEnabled($articleId)
    {
        $article = Database::getInstance()->prepare("SELECT elementsFilter_enable FROM tl_article WHERE id=?")
            ->execute($articleId);

        return $article->elementsFilter_enable ? true : false;
    }

    /**
     * Get the javascript handler assets
     *
     * @param int $articleId
     *
     * @return array|null
     */
    public static function getHandlerAssets($articleId)
    {
        if (!static::isArticleEnabled($articleId)) {
            return null;
        }

        $assets = ['system/modules/elements-filter/assets/handler/handler.min.js'];

        $article = Database::getInstance()->prepare("SELECT elementsFilter_handler FROM tl_article WHERE id=?")
            ->execute($articleId);

        if ($article->elementsFilter_handler === 'isotope') {
            $assets[] = 'system/modules/elements-filter/assets/isotope/isotope.pkgd.min.js';
        }

        return $assets;
    }

    /**
     * Get the article filters
     *
     * @param int $articleId
     *
     * @return array
     */
    public static function getArticleFilters($articleId)
    {
        if (!static::isArticleEnabled($articleId)) {
            return [];
        }

        $filters = [];
        $article = Database::getInstance()->prepare("SELECT elementsFilter_filters FROM tl_article WHERE id=?")
            ->execute($articleId);

        foreach (deserialize($article->elementsFilter_filters, true) as $filter) {
            $filters[] = [
                'value'    => $filter['elementsFilter_filters_value'],
                'label'    => $filter['elementsFilter_filters_label'],
                'cssClass' => $filter['elementsFilter_filters_cssClass'],
            ];
        }

        return $filters;
    }
}
