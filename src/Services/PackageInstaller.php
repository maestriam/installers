<?php

namespace Maestriam\Installers\Services;

use Composer\Installers\Installer;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Maestriam\Installers\Exceptions\PackageInstallerException;

class PackageInstaller extends Installer
{
    private $installers = [
        'blade-theme' => ThemeInstaller::class
    ];

    private $instances = [];


    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package) : string
    {
        $installer = $this->getInstaller($package);

        return $installer->getInstallPath($package);
    }

    /**
     * Get the base path that the module should be installed into.
     * Defaults to Modules/ and can be overridden in the module's composer.json.
     *
     * @return string
     */
    /*protected function getBaseInstallationPath()
    {
        if (!$this->composer || !$this->composer->getPackage()) {
            return self::DEFAULT_ROOT;
        }

        $extra = $this->composer->getPackage()->getExtra();

        if (!$extra || empty($extra['module-dir'])) {
            return self::DEFAULT_ROOT;
        }

        return $extra['module-dir'];
    }*/

    /**
     * Get the module name, i.e. "joshbrw/something-module" will be transformed into "Something"
     *
     * @param PackageInterface $package Compose Package Interface
     *
     * @return string Module Name
     *
     * @throws PackageInstallerException
     */
    /*protected function getModuleName(PackageInterface $package)
    {
        $name = $package->getPrettyName();
        $split = explode("/", $name);

        if (count($split) !== 2) {
            throw PackageInstallerException::fromInvalidPackage($name);
        }

        $splitNameToUse = explode("-", $split[1]);

        if (count($splitNameToUse) < 2) {
            throw PackageInstallerException::fromInvalidPackage($name);
        }

        if (array_pop($splitNameToUse) !== 'module') {
            throw PackageInstallerException::fromInvalidPackage($name);
        }

        return implode('', array_map('ucfirst', $splitNameToUse));
    }*/

    /**
     * {@inheritDoc}
     */
    public function supports($type) : bool
    {
        return (array_key_exists($type, $this->installers));
    }

    /**
     * Retorna a instância de um instalador, baseado no tipo de
     * pacote do Composer. 
     * 
     * @return BaseInstaller
     */
    public function getInstaller(PackageInterface $package) : BaseInstaller
    {
        $type = $package->getType();

        $class = $this->installers[$type];
      
        return new $class($this->io, $this->composer, $type);        
    }
}