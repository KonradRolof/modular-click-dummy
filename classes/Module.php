<?php
namespace classes;

class Module
{
    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var null
     */
    protected $vars = null;

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
     * @return null|array
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
     * @param string $templateDir
     *
     * @return $this
     * @throws Exception
     */
    protected function checkTemplateFile($templateDir)
    {
        if (file_exists($templateDir)) {
            return $this;
        } else {
            throw new Exception('Exception: File ' . $templateDir . 'not found.');
        }
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * @param null|array $newVars
     */
    public function render($newVars = null)
    {
        $template = BASE_DIR . '/inc/' . $this->getTemplate();
        try {
            // TODO clean this code from line 103 to 108
            $defaults = $this->getVars();
            $this->checkTemplateFile($template);
            if (is_array($defaults)) {
                $varsArr = is_array($newVars) ? array_merge($defaults, $newVars) : $defaults;
                extract($varsArr);
            }
            include $template;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}