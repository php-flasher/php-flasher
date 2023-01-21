<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $config) {
    $config->packageDirectories(array(
        __DIR__.'/src',
    ));

    $config->packageAliasFormat('2.x-dev');

    $config->workers(array(
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker',
    ));
};
