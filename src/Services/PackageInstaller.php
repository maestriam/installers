<?php

namespace Maestriam\Installers\Services;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class PackageInstaller extends LibraryInstaller
{
    private $installers = [
        'blade-theme'    => ThemeInstaller::class,
        'maestro-module' => ModuleInstaller::class,
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
