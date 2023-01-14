<?php

namespace Maestriam\Installers\Services;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Maestriam\Installers\Exceptions\PackageInstallerException;

class BaseInstaller extends LibraryInstaller
{
    public $defaultRoot;

    public $extraKey;

    public function getInstallPath(PackageInterface $package)
    {
        return $this->getBaseInstallationPath() . '/' . $this->getModuleName($package);
    }

    /**
     * Get the base path that the module should be installed into.
     * Defaults to Modules/ and can be overridden in the module's composer.json.
     *
     * @return string
     */
    protected function getBaseInstallationPath()
    {
        if (!$this->composer || !$this->composer->getPackage()) {
            return $this->defaultRoot;
        }

        $extra = $this->composer->getPackage()->getExtra();

        if (!$extra || empty($extra[$this->extraKey])) {
            return $this->defaultRoot;
        }

        return $extra[$this->extraKey];
    }

    /**
     * Get the module name, i.e. "joshbrw/something-module" will be transformed into "Something"
     *
     * @param PackageInterface $package Compose Package Interface
     *
     * @return string Module Name
     *
     * @throws PackageInstallerException
     */
    protected function getModuleName(PackageInterface $package)
    {
        $name = $package->getPrettyName();        
        $split = explode("/", $name);

        if (count($split) !== 2) {
            throw PackageInstallerException::fromInvalidPackage($name);
        }

        return $name;
    }
}