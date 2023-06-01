<?php

namespace Codefog\ElementsFilterBundle\EventListener;

use Codefog\ElementsFilterBundle\FilterHelper;
use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\Input;

class ContentDataContainerListener
{
    public function __construct(private readonly FilterHelper $filterHelper)
    {
    }

    #[AsCallback('tl_content', 'config.onload')]
    public function onLoadCallback(DataContainer $dc): void
    {
        if (Input::get('act') && Input::get('act') !== 'editAll' && Input::get('act') !== 'overrideAll') {
            $articleId = ContentModel::findByPk($dc->id)?->pid;
        } else {
            $articleId = $dc->id;
        }

        if (!$articleId || !$this->filterHelper->isArticleEnabled($articleId)) {
            return;
        }

        foreach ($GLOBALS['TL_DCA'][$dc->table]['palettes'] as $k => $v) {
            if (!\is_string($v)) {
                continue;
            }

            PaletteManipulator::create()
                ->addLegend('elementsFilter_legend', 'protected_legend', PaletteManipulator::POSITION_AFTER)
                ->addField('elementsFilter_filters', 'elementsFilter_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette($k, $dc->table)
            ;
        }
    }

    #[AsCallback('tl_content', 'fields.elementsFilter_filters.options')]
    public function getFilters(DataContainer $dc): array
    {
        $articleId = Input::get('act') ? ContentModel::findByPk($dc->id)?->pid : $dc->id;

        if (!$articleId || ($filterCollection = $this->filterHelper->getArticleFilterCollection($articleId)) === null) {
            return [];
        }

        $filters = [];
        $currentGroup = null;

        foreach ($filterCollection->all() as $filter) {
            if ($filter['group']) {
                $currentGroup = $filter['label'];
                continue;
            }

            if (!$filter['value']) {
                continue;
            }

            if ($currentGroup !== null) {
                $filters[$currentGroup][$filter['value']] = $filter['label'];
            } else {
                $filters[$filter['value']] = $filter['label'];
            }
        }

        return $filters;
    }
}
