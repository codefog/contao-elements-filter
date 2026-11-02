<?php

namespace Codefog\ElementsFilterBundle\Twig\Extension;

use Codefog\ElementsFilterBundle\FilterHelper;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\StringUtil;
use Twig\Attribute\AsTwigFunction;

readonly class ElementsFilterExtension
{
    public function __construct(
        private FilterHelper $filterHelper,
        private ScopeMatcher $scopeMatcher,
    )
    {
    }

    #[AsTwigFunction('elements_filter_attributes', needsContext: true)]
    public function getElementsFilterAttributes(array $context): HtmlAttributes
    {
        $attributes = new HtmlAttributes();

        if ($this->scopeMatcher->isFrontendRequest() && isset($context['data']) && $this->filterHelper->isArticleEnabled($context['data']['pid'])) {
            $filters = StringUtil::deserialize($context['data']['elementsFilter_filters']);

            if (is_array($filters) && [] !== $filters) {
                $attributes->set('data-elements-filter', implode(',', $filters));
            }
        }

        return $attributes;
    }
}
