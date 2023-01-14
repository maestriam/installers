<?php

namespace Maestriam\Installers\Tests;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Package\Version\VersionParser;
use Composer\Package\Package;
use Composer\Package\AliasPackage;
use Composer\Package\RootPackage;
use Composer\Semver\Constraint\Constraint;
use Composer\Util\Filesystem;
use Composer\Installer\InstallationManager;
use Composer\Repository\RepositoryManager;
use Composer\Downloader\DownloadManager;
use Maestriam\Installers\Services\PackageInstaller;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var ?VersionParser */
    private static $parser = null;

    protected static function getVersionParser(): VersionParser
    {
        if (!self::$parser) {
            self::$parser = new VersionParser();
        }

        return self::$parser;
    }

    /**
     * @param Constraint::STR_OP_* $operator
     */
    protected function getVersionConstraint(string $operator, string $version): Constraint
    {
        $version = self::getVersionParser()->normalize($version);

        return new Constraint($operator, $version);
    }

    protected function getPackage(string $name, string $type = 'library'): Package
    {
        $version = '1.0.0';
        $normVersion = self::getVersionParser()->normalize($version);
        
        $package = new Package($name, $normVersion, $version);
        $package->setType($type);

        return $package;
    }

    protected function getAliasPackage(Package $package, string $version): AliasPackage
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new AliasPackage($package, $normVersion, $version);
    }

    protected function getComposer(): Composer
    {
        $config = new Config(false);
        $package = $this->getRootPackage();
        $download = $this->getDownloadManager(); 
        $repository = $this->getRepositoryManager();
        $installation = $this->getInstallationManager();

        $composer = new Composer;

        $composer->setConfig($config);        
        $composer->setPackage($package);
        $composer->setDownloadManager($download);
        $composer->setRepositoryManager($repository);
        $composer->setInstallationManager($installation);

        return $composer;
    }

    protected function getRootPackage($name = null, $v = null) : RootPackage 
    {
        $pretty = $v ?? '1.0.0';
        $full   = $pretty . '.0';         
        $name   = $name ?? 'root/pkg';

        return new RootPackage($name, $full, $pretty);        
    }

    protected function getRepositoryManager()
    {
        return $this->getMockBuilder(RepositoryManager::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    protected function getDownloadManager()
    {
        return $this->getMockBuilder(DownloadManager::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    protected function getMockIO(): IOInterface
    {
        return $this->getMockBuilder(IOInterface::class)
                    ->getMock();
    }

    protected function getInstallationManager()
    {
        return $this->getMockBuilder(InstallationManager::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    protected function getInstaller()
    {
        $composer = $this->getComposer();
        
        return new PackageInstaller($this->getMockIO(), $composer);
    }
}