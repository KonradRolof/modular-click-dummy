<?php
namespace classes;

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
            $namesArray[] = $name[0];
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
     * @param $directoryString
     *
     * @return $this
     */
    protected function setModulesDir($directoryString)
    {
        $this->modulesDir = $directoryString;

        return $this;
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
                if ($entry !== '.' && $entry !== '..' && substr($entry, 0, 1) !== '_') {
                    $fileNames[] = $entry;
                }
            }
            closedir($handle);
        }

        return $fileNames;
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