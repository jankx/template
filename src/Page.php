<?php
namespace Jankx\Template;

use Jankx;
use Jankx\Template\Template;

class Page
{
    protected static $instance;

    protected $baseFileName;
    protected $templateFile;
    protected $context;
    protected $partialName;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // Please create the Jankx Page via method getInstance()
    }

    /**
     * Get the original template file
     *
     * @return string
     */
    public function getTemplateFile()
    {
        if (PHP_OS === 'WINNT') {
            return str_replace('\\', '/', $this->templateFile);
        }
        return $this->templateFile;
    }

    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * Get the current context
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    public function setPartialName($partialName)
    {
        $this->partialName = $partialName;
    }

    public function generateTemplateNames()
    {
        return $this->context;
    }

    /**
     * The main template render
     *
     * @param string $context Create the action hook via render context
     * @return void
     */
    public function render()
    {
        $engine = Template::getEngine(Jankx::ENGINE_ID);

        do_action_ref_array( 'jankx_prepare_render_template', array(
            &$engine,
            $this
        ));

        $engine->render($this->generateTemplateNames());
    }
}
