<?php
namespace classes;

use Exception;

/**
 * Class Module
 * @author Konrad Rolof <info@konrad-rolof.de>
 * @package classes
 */
class Module
{
    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var array
     */
    protected $vars = array();

    /**
     * Module constructor.
     *
     * @param null|string $template
     */
    public function __construct($template = null)
    {
        if ($template !== null) {
            try {
                $this
                    ->validateTemplate($template)
                    ->setTemplate($template)
                ;
            } catch (Exception $e) {
                echo 'Exeption: ' . $e->getMessage();
            }
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return __DIR__ . '/../inc/' . $this->getTemplate();
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    protected function setTemplate($template)
    {
        $this->template = $template . '.inc.php';
    }

    /**
     * @return array
     */
    protected function getVars()
    {
        return $this->vars;
    }

    /**
     * @param $template
     *
     * @return $this
     * @throws Exception
     */
    protected function validateTemplate($template)
    {
        if (!is_string($template)) {
            throw new Exception('Exception: Template variable has wrong data type.');
        }
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function validateDefaultVars()
    {
        if (!is_array($this->getVars())) {
            throw new Exception('An associative array is needed to set default variables.');
        }
        return $this;
    }

    /**
     * @param $overWriteVars
     *
     * @return $this
     * @throws Exception
     */
    protected function validateOverWriteVars($overWriteVars)
    {
        if (!is_array($overWriteVars) & $overWriteVars !== null) {
            throw new Exception('An associative array is needed to overwrite the default variables.');
        }
        return $this;
    }

    /**
     * @param string $templateDir
     *
     * @return $this
     * @throws Exception
     */
    protected function checkTemplateFile($templateDir)
    {
        if (!file_exists($templateDir)) {
            throw new Exception('Exception: File ' . $templateDir . 'not found.');
        }
        return $this;
    }

    /**
     * @param $overWriteVars
     *
     * @return array
     */
    protected function checkAndMergeVars($overWriteVars)
    {
        $this
            ->validateDefaultVars()
            ->validateOverWriteVars($overWriteVars)
        ;
        $defaults = $this->getVars();
        $varsArray = !empty($defaults) && is_array($overWriteVars) ? array_merge($defaults, $overWriteVars) : $defaults;
        return $varsArray;
    }

    /**
     * @param $vars
     */
    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    /**
     * @param null|array $overWriteVars
     */
    public function render($overWriteVars = null)
    {
        $template = __DIR__ . '/../inc/' . $this->getTemplate();
        try {
            $this->checkTemplateFile($template);
            extract($this->checkAndMergeVars($overWriteVars), EXTR_OVERWRITE);
            include $template;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}