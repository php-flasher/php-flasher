<?php

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $config) {
    $config->packageDirectories([
        __DIR__.'/src',
    ]);

    $config->packageAliasFormat('2.x-dev');

    $config->workers([
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker',
        // 'Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker',
    ]);
};
