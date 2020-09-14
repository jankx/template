<?php
namespace Jankx\Template;

use Jankx\Template\Template;

class Page
{
    protected static $instance;

    protected $isCustomTemplate;
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
     * Check the page tempalte is custom by plugin or not
     * If the template called from theme will be return false
     *
     * @return boolean
     */
    public function isCustomTemplate()
    {
        return (boolean)$this->isCustomTemplate;
    }

    /**
     * Get the original template file
     *
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    /**
     * Get the original template file name
     *
     * @return string
     */
    public function getBaseFileName()
    {
        return $this->baseFileName;
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

    /**
     * Set the original template file to page template
     *
     * @param string $template The WordPress template is called
     * @return string
     */
    public function callTemplate($template)
    {
        $this->templateFile = $template;
        $this->isCustomTemplate = is_numeric(
            strpos($template, WP_PLUGIN_DIR)
        );
        $this->baseFileName = basename($template);
        if (preg_match('/(\w{1,})-?([^\.]*)?/', $this->baseFileName, $matches)) {
            $this->context = $matches[1];
            if (isset($matches[2])) {
                $this->partialName = $matches[2];
            }
        }

        // Create new hook to setup page
        do_action('jankx_call_page_template', $this);

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
        get_header($this->partialName ? $this->partialName : $this->context);

        // Setup post data
        if (is_singular() && have_posts()) {
            the_post();
        }

        if (empty($context)) {
            $context = $this->context;
        }
        if ($context === 'single' && empty($this->partialName)) {
            $this->partialName = get_post_type();
        }
        $context      = $this->isCustomTemplate() ? sprintf('plugin_%s', $context) : $context;
        $templateHook = sprintf('jankx_template_page_%s_%s', $context, $this->partialName);

        if (has_action($templateHook)) {
            do_action($templateHook, $context, $this->partialName, $this->isCustomTemplate);
        } else {
            $templates = [];

            if ($this->partialName !== '') {
                $templates[] = sprintf('content/%s/%s', $context, $this->partialName);
                $templates[] = sprintf('content/%s-%s', $context, $this->partialName);
            }
            $templates[] = 'content/' . $context;

            jankx_template(
                $templates,
                apply_filters("jankx_template_page_{$context}_data", [])
            );
        }

        $footerActiveStatus = apply_filters('jankx_is_active_footer', true, $this);
        if ($footerActiveStatus) {
            $footerName = $this->partialName ? $this->partialName : $this->context;
        } else {
            $footerName = 'blank';
        }
        get_footer($footerName);
    }
}
