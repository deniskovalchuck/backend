<?php

class Autoloader
{
    private $projectDirectory;
    public function __construct($projectDirectory, array $namespaces)
    {
        $this->projectDirectory = $projectDirectory;

        foreach ($namespaces as $namespace => $relativePath) {
            $this->map($namespace, $relativePath);
        }
    }
    private function map($namespace, $path)
    {
        $namespacePrefix = "{$namespace}\\";
        $namespacePrefixLength = strlen($namespacePrefix);
        $absolutePath = $this->getAbsolutePath($path);
        $autoloader = function ($class) use ($namespacePrefix, $namespacePrefixLength, $absolutePath) {
            if (strncmp($class, $namespacePrefix, $namespacePrefixLength) !== 0) {
                return;
            }
            $relativeClassName = substr($class, $namespacePrefixLength);
            $relativeFilePath = strtr($relativeClassName, '\\', DIRECTORY_SEPARATOR) . '.php';
            $absoluteFilePath = $absolutePath . DIRECTORY_SEPARATOR . $relativeFilePath;

            if (is_file($absoluteFilePath)) {
                include $absoluteFilePath;
            }
        };

        spl_autoload_register($autoloader);
    }
    private function getAbsolutePath($path)
    {
        if ($this->isAbsolutePath($path)) {
            return $path;
        }
        return $this->projectDirectory . DIRECTORY_SEPARATOR . $path;
    }
    private function isAbsolutePath($path)
    {
        return substr($path, 0, 1) === '/';
    }
}
new Autoloader(AppDir, $namespaces);
