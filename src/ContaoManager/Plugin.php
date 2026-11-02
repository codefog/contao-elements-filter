<?php

declare(strict_types=1);

namespace Codefog\ElementsFilterBundle\ContaoManager;

use Codefog\ElementsFilterBundle\CodefogElementsFilterBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MenAtWork\MultiColumnWizardBundle\MultiColumnWizardBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(CodefogElementsFilterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, MultiColumnWizardBundle::class]),
        ];
    }
}
