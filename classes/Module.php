<?php

class Module
{
    protected $template = '';

    protected $vars = null;

    public function __construct($template = null)
    {
        if ($template !== null) {
            try {
                $tpl = $this->validateTemplate($template);
                $this->setTemplate($tpl);
            } catch (Exception $e) {
                echo 'Exeption: ' . $e->getMessage();
            }
        }
    }

    protected function getTemplate()
    {
        return $this->template;
    }

    protected function setTemplate($template)
    {
        $this->template = $template . '.inc.php';
    }

    protected function getVars()
    {
        return $this->vars;
    }

    protected function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    protected function validateTemplate($template)
    {
        if (!is_string($template)) {
            throw new Exception('Template variable has wrong data type.');
        }
        return $template;
    }

    public function render($newVars = null)
    {
        $template = BASE_DIR . 'inc/' . $this->getTemplate();
        if (file_exists($template)) {
            require $template;
        }
    }
}