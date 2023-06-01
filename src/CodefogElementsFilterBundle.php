<?php

declare(strict_types=1);

namespace Codefog\ElementsFilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodefogElementsFilterBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}
