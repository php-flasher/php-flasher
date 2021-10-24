<?php

namespace Flasher\Cli\Symfony;

use Flasher\Cli\Prime\Stamp\DesktopStamp;
use Flasher\Cli\Symfony\DependencyInjection\Compiler\NotifierCompilerPass;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Cli\Symfony\DependencyInjection\FlasherCliExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherCliSymfonyBundle extends FlasherBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function boot()
    {
        NotificationBuilder::macro('desktop', function ($renderImmediately = true) {
            return $this->withStamp(new DesktopStamp($renderImmediately));
        });
    }

    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new NotifierCompilerPass());
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherCliExtension();
    }
}
