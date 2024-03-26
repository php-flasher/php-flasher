<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $config) {
    $config->packageDirectories([
        __DIR__.'/src',
    ]);
};
