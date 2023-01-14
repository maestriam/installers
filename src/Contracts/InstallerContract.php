<?php

namespace Maestriam\Installers\Contracts;

use Composer\Package\PackageInterface;

interface InstallerContract 
{
    public function getBaseInstallationPath();

    public function getModuleName(PackageInterface $package);
}