<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Symfony\Bridge\Bridge;

if (Bridge::versionCompare('6.0', '>=')) {
    eval('
        namespace Flasher\Tests\Symfony;

        class FlasherKernel extends AbstractFlasherKernel
        {
            public function registerBundles(): iterable
            {
                return $this->doRegisterBundles();
            }

            public function getCacheDir(): string
            {
                return $this->doGetLogDir();
            }

            public function getLogDir(): string
            {
                return $this->doGetLogDir();
            }

            public function getProjectDir(): string
            {
                return \dirname(__DIR__);
            }
        }
    ');
} else {
    final class FlasherKernel extends AbstractFlasherKernel
    {
        public function registerBundles(): iterable
        {
            return $this->doRegisterBundles();
        }

        public function getCacheDir(): string
        {
            return $this->doGetLogDir();
        }

        public function getLogDir(): string
        {
            return $this->doGetLogDir();
        }
    }
}

final class FlasherKernel extends AbstractFlasherKernel
{
    public function registerBundles(): iterable
    {
        return $this->doRegisterBundles();
    }

    public function getCacheDir(): string
    {
        return $this->doGetLogDir();
    }

    public function getLogDir(): string
    {
        return $this->doGetLogDir();
    }
}
