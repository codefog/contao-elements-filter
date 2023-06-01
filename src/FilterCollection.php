<?php

namespace Codefog\ElementsFilterBundle;

class FilterCollection
{
    private ?bool $hasGroups = null;

    public function __construct(private readonly array $filters)
    {
    }

    public function all(): array
    {
        return $this->filters;
    }

    public function allGrouped(): array
    {
        if (!$this->hasGroups()) {
            throw new \RuntimeException('There are no groups in this collection');
        }

        $grouped = [];
        $currentGroup = null;

        foreach ($this->filters as $filter) {
            if ($filter['group']) {
                $currentGroup = $filter['value'];

                $grouped[$currentGroup] = [
                    'value' => $filter['value'],
                    'label' => $filter['label'],
                    'cssClass' => $filter['cssClass'],
                    'options' => [],
                ];

                continue;
            }

            if (!$filter['value'] || $currentGroup === null) {
                continue;
            }

            $grouped[$currentGroup]['options'][] = [
                'value' => $filter['value'],
                'label' => $filter['label'],
                'cssClass' => $filter['cssClass'],
            ];
        }

        return $grouped;
    }

    public function hasGroups(): bool
    {
        if ($this->hasGroups === null) {
            $this->hasGroups = false;

            foreach ($this->filters as $filter) {
                if ($filter['group']) {
                    $this->hasGroups = true;
                    break;
                }
            }
        }

        return $this->hasGroups;
    }
}
