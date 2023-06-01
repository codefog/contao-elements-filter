<?php

namespace Codefog\ElementsFilterBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\StringUtil;
use Contao\Template;
use Codefog\ElementsFilterBundle\FilterHelper;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('parseTemplate')]
class ParseTemplateListener
{
    public function __construct(
        private readonly FilterHelper $filterHelper,
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    )
    {
    }

    public function __invoke(Template $template): void
    {
        $this->handleArticleTemplate($template);
        $this->handleElementTemplate($template);
    }

    private function handleArticleTemplate(Template $template): void
    {
        if (!str_starts_with($template->getName(), 'mod_article')
            || ($request = $this->requestStack->getCurrentRequest()) === null
            || !$this->scopeMatcher->isFrontendRequest($request)
            || !$this->filterHelper->isArticleEnabled($template->id)
        ) {
            return;
        }

        // Override the template but only if there is no custom yet
        if (!$template->customTpl) {
            $template->setName('mod_article_elements_filter');
        }

        $collection = $this->filterHelper->getArticleFilterCollection($template->id);

        $template->elementsFilters = $collection->hasGroups() ? $collection->allGrouped() : $collection->all();
        $template->elementsFiltersGrouped = $collection->hasGroups();
        $template->elementsFiltersHandler = $template->elementsFilter_handler;

        // Add the handler assets
        foreach ($this->filterHelper->getJavaScriptAssets($template->id) as $asset) {
            $GLOBALS['TL_JAVASCRIPT'][] = $asset;
        }
    }

    private function handleElementTemplate(Template $template): void
    {
        if ((!str_starts_with($template->getName(), 'ce_') && !str_starts_with($template->getName(), 'rsce_'))
            || ($request = $this->requestStack->getCurrentRequest()) === null
            || !$this->scopeMatcher->isFrontendRequest($request)
            || !$this->filterHelper->isArticleEnabled($template->pid)
            || !is_array($filters = StringUtil::deserialize($template->elementsFilter_filters))
            || empty($filters)
        ) {
            return;
        }

        $template->cssID = trim($template->cssID.' '.sprintf('data-elements-filter="%s"', implode(',', $filters)));
    }
}
