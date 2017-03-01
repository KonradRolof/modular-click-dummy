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
                $this->renderException($e);
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
     * echo and exception message box with useful information for better debugging
     *
     * @param Exception $exception
     */
    protected function renderException(Exception $exception)
    {
        $trace = $exception->getTrace();
        $trace = $trace[count($trace)-1];
        echo '<div style="background:#e74c3c;border:2px solid #c0392b;padding:10px;margin:5px">'
            . '<p style="margin:0 0 1px;padding:0;color:white;font-size:14px;line-height:1.2">'
            . 'Exception in file <b>'
            . $trace['file']
            . '</b> on line <b>'
            . $trace['line']
            . '</b>:<br>'
            . $exception->getMessage()
            . '</p>'
            . '</div>'
        ;
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
        try {
            $template = __DIR__ . '/../inc/' . $this->getTemplate();
            $this->checkTemplateFile($template);
            extract($this->checkAndMergeVars($overWriteVars), EXTR_OVERWRITE);
            include $template;
        } catch (Exception $e) {
            $this->renderException($e);
        }
    }
}