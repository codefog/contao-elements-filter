<?php

namespace Codefog\ElementsFilterBundle;

use Contao\ArticleModel;
use Contao\StringUtil;
use Symfony\Component\Asset\Packages;

class FilterHelper
{
    public function __construct(private readonly Packages $packages)
    {
    }

    /**
     * Return true if the elements filter are enabled for given article ID.
     */
    public function isArticleEnabled(int $articleId): bool
    {
        if (!$articleId) {
            return false;
        }

        return (bool) ArticleModel::findByPk($articleId)?->elementsFilter_enable;
    }

    /**
     * Get the JavaScript assets.
     */
    public function getJavaScriptAssets(int $articleId): ?array
    {
        if (!$this->isArticleEnabled($articleId)) {
            return null;
        }

        $assets = [$this->packages->getUrl('frontend.js', 'codefog_elements_filter')];

        if (ArticleModel::findByPk($articleId)?->elementsFilter_handler === 'isotope') {
            array_unshift($assets, $this->packages->getUrl('isotope.pkgd.min.js', 'codefog_elements_filter'));
        }

        return $assets;
    }

    /**
     * Get the article filters
     */
    public function getArticleFilters(int $articleId): array
    {
        if (!$this->isArticleEnabled($articleId)) {
            return [];
        }

        $filtersData = ArticleModel::findByPk($articleId)?->elementsFilter_filters;
        $filtersData = StringUtil::deserialize($filtersData);

        if (!is_array($filtersData) || empty($filtersData)) {
            return [];
        }

        $filters = [];

        foreach ($filtersData as $filter) {
            $filters[] = [
                'value' => $filter['elementsFilter_filters_value'],
                'label' => $filter['elementsFilter_filters_label'],
                'cssClass' => $filter['elementsFilter_filters_cssClass'],
            ];
        }

        return $filters;
    }
}
