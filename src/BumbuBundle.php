<?php

namespace IS\Bumbu;

use IS\Bumbu\Compiler\CustomCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BumbuBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new CustomCompilerPass());
    }
}