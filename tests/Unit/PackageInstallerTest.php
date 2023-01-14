<?php

namespace Maestriam\Installers\Tests\Unit;

use Maestriam\Installers\Tests\TestCase;
use Maestriam\Installers\Services\PackageInstaller;

class PackageInstallerTest extends TestCase
{
    public function testGetInstallPath()
    {
        $installer = $this->getInstaller();
        $package = $this->getPackage('maestriam/stylus', 'blade-theme');
        
        $expected = 'themes/maestriam/stylus';        
        $actual = $installer->getInstallPath($package);

        $this->assertEquals($expected, $actual);
    }
}