<?php

namespace Maestriam\Installers\Exceptions;

use Exception;

class PackageInstallerException extends Exception
{
    public static function fromInvalidPackage(string $package): self
    {
        $pattern = "Ensure your package's name ({%s}) is in the format <vendor>/<name>";
        $message = sprintf($pattern, $package);

        return new self($message);
    }
}