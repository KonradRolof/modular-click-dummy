<?php
namespace classes;

use Exception;
use classes\Module;

class ModuleAutoLoader
{
    protected $modules = [];

    protected $moduleNames = [];

    protected $modulesDir = __Dir__ . '/../inc';

    public function getModules()
    {
        return $this->modules;
    }

    private function setModules(array $modulesArray)
    {
        $this->modules = $modulesArray;

        return $this;
    }

    public function getModuleNames()
    {
        return $this->moduleNames;
    }

    protected function setModuleNames(array $filesArray)
    {
        $namesArray = [];

        foreach ($filesArray as $file) {
            $name = explode('.', $file, 2);
            $namesArray[] = $name[0];
        }

        $this->moduleNames = $namesArray;

        return $this;
    }

    protected function getModulesDir()
    {
        return $this->modulesDir;
    }

    protected function setModulesDir($directoryString)
    {
        $this->modulesDir = $directoryString;

        return $this;
    }

    public function loadFiles()
    {
        $self = $this;
        $fileNames = [];

        if ($handle = opendir($self->getModulesDir())) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry !== '.' && $entry !== '..' && substr($entry, 0, 1) !== '_') {
                    $fileNames[] = $entry;
                }
            }
            closedir($handle);
        }

        return $fileNames;
    }

    public function getModulesFromFiles()
    {
        $files = $this->loadFiles();
        $this->setModuleNames($files);

        return $this->getModuleNames();
    }
}