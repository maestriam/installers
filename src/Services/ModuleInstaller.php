<?php

namespace Maestriam\Installers\Services;

use Composer\Package\PackageInterface;
use Maestriam\Installers\Exceptions\PackageInstallerException;

class ModuleInstaller extends BaseInstaller
{
    public $defaultRoot = 'maestro';

    protected function getModuleName(PackageInterface $package)
    {
        $name = $package->getPrettyName();              
        $split = explode("/", $name);

        if (count($split) !== 2) {
            throw PackageInstallerException::fromInvalidPackage($name);
        }

        return ucfirst($split[1]);
    }
}
