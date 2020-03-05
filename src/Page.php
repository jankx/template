<?php
namespace Jankx\Template;

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

    /**
     * Set the original template file to page template
     *
     * @param string $template The WordPress template is called
     * @return string
     */
    public function callTemplate($template)
    {
        $this->templateFile = $template;
        $this->baseFileName = basename($template);
        if (preg_match('/(\w{1,})(-[^\.]*)?/', $this->baseFileName, $matches)) {
            $this->context = $matches[1];
            if (isset($matches[2])) {
                $this->partialName = $matches[2];
            }
        }

        return $template;
    }

    /**
     * The main template render
     *
     * @param string $context Create the action hook via render context
     * @return void
     */
    public function render($context = '')
    {
        /**
         * Get site header
         */
        get_header();
        /**
         * Get site footer
         */
        get_footer();
    }
}
