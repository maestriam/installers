<?php

namespace Maestriam\Installers\Tests\Unit;

use Maestriam\Installers\Tests\TestCase;
use Maestriam\Installers\Services\PackageInstaller;

class PackageInstallerTest extends TestCase
{
    public function testGetInstallThemePath()
    {
        $installer = $this->getInstaller();
        $package   = $this->getPackage('maestriam/stylus', 'blade-theme');
        
        $expected = 'themes/maestriam/stylus';        
        $actual   = $installer->getInstallPath($package);

        $this->assertEquals($expected, $actual);
    }

    public function testGetInstallModulePath()
    {
        $installer = $this->getInstaller();
        $package   = $this->getPackage('strauss/users', 'strauss-module');
        
        $expected = 'strauss/Users';
        $actual   = $installer->getInstallPath($package);

        $this->assertEquals($expected, $actual);
    }
}