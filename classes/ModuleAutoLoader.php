<?php
namespace classes;

use Exception;

/**
 * Class ModuleAutoLoader
 * @author Konrad Rolof <info@konrad-rolof.de>
 * @package classes
 */
class ModuleAutoLoader
{
    /**
     * @var array
     */
    protected $modules = [];
    /**
     * @var array
     */
    protected $moduleNames = [];
    /**
     * @var string
     */
    protected $modulesDir = __Dir__ . '/../inc';

    /**
     * @param array $moduleNamesArray
     *
     * @return $this
     */
    private function setModules(array $moduleNamesArray)
    {
        $modulesArray = [];

        foreach ($moduleNamesArray as $moduleName) {
            $modulesArray[$moduleName] = new Module($moduleName);
        }

        $this->modules = $modulesArray;

        return $this;
    }

    /**
     * @param array $filesArray
     *
     * @return $this
     */
    protected function setModuleNames(array $filesArray)
    {
        $namesArray = [];

        foreach ($filesArray as $file) {
            $name = explode('.inc', $file, 2);
            if (!array_key_exists($name[0], $namesArray)) {
                $namesArray[] = $name[0];
            }
        }

        $this->moduleNames = $namesArray;

        return $this;
    }

    /**
     * @return string
     */
    protected function getModulesDir()
    {
        return $this->modulesDir;
    }

    /**
     * check directory for files and return array of file names
     *
     * @return array
     */
    protected function loadFiles()
    {
        $self = $this;
        $fileNames = [];

        if ($handle = opendir($self->getModulesDir())) {
            while (false !== ($entry = readdir($handle))) {
                $firstChar = substr($entry, 0, 1);
                if ($firstChar !== '.' && $firstChar !== '_') {
                    $fileNames[] = $entry;
                }
            }
            closedir($handle);
        }

        return $fileNames;
    }

    /**
     * @param $directoryString
     *
     * @return $this
     * @throws Exception
     */
    public function setModulesDir($directoryString)
    {
        if (!is_string($directoryString)) {
            throw new Exception('Directory must be given as string.');
        }
        $this->modulesDir = $directoryString;

        return $this;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return array
     */
    public function getModuleNames()
    {
        return $this->moduleNames;
    }

    /**
     * return an array of modules form files in directory
     *
     * @return array
     */
    public function getModulesFromFiles()
    {
        $files = $this->loadFiles();
        $this->setModuleNames($files);
        $fileNames = $this->getModuleNames();
        $this->setModules($fileNames);

        return $this->getModules();
    }
}