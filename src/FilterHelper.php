<?php

namespace Codefog\ElementsFilterBundle;

use Contao\ArticleModel;
use Contao\StringUtil;
use Symfony\Component\Asset\Packages;

readonly class FilterHelper
{
    public function __construct(private Packages $packages)
    {
    }

    /**
     * Return true if the elements filter are enabled for given article ID.
     */
    public function isArticleEnabled(int|null $articleId): bool
    {
        if (!$articleId) {
            return false;
        }

        return (bool) ArticleModel::findByPk($articleId)?->elementsFilter_enable;
    }

    /**
     * Get the JavaScript assets.
     */
    public function getJavaScriptAssets(int|null $articleId): array
    {
        if (!$this->isArticleEnabled($articleId)) {
            return [];
        }

        $assets = [$this->packages->getUrl('frontend.js', 'codefog_elements_filter')];

        if (ArticleModel::findByPk($articleId)?->elementsFilter_handler === 'isotope') {
            array_unshift($assets, $this->packages->getUrl('isotope.pkgd.min.js', 'codefog_elements_filter'));
        }

        return $assets;
    }

    /**
     * Get the article filter collection.
     */
    public function getArticleFilterCollection(int|null $articleId): ?FilterCollection
    {
        if (!$this->isArticleEnabled($articleId)) {
            return null;
        }

        $filtersData = ArticleModel::findByPk($articleId)?->elementsFilter_filters;
        $filtersData = StringUtil::deserialize($filtersData);

        if (!is_array($filtersData) || empty($filtersData)) {
            return null;
        }

        $filters = [];

        foreach ($filtersData as $filter) {
            $filters[] = [
                'value' => $filter['value'],
                'label' => $filter['label'],
                'cssClass' => $filter['cssClass'],
                'group' => (bool) ($filter['group'] ?? false),
            ];
        }

        return new FilterCollection($filters);
    }
}
