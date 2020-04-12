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

        if (empty($context)) {
            $context = $this->context;
        }
        $context = $this->isCustomTemplate() ? sprintf('plugin_%s', $context) : $context;
        $template_hook = sprintf('jankx_page_template_%s', $context);
        
        if (has_action($template_hook)) {
            do_action($template_hook, $context, $this->partialName, $this->isCustomTemplate);
        } else {
            $is_mobile = apply_filters('jankx_is_mobile_template', wp_is_mobile());
            $templates = [];

            if ($this->partialName !== '') {
                $template_file = sprintf('content/%s-%s', $context, $this->partialName);
                if ($is_mobile) {
                    $templates[] = 'mobile/' . $template_file;
                }
                $templates[] = $template_file;
            }

            $template_file = 'content/' . $context;
            if ($is_mobile) {
                $templates[] = 'mobile/' . $template_file;
            }
            $templates[] = 'content/' . $context;

            jankx_template(
                $templates,
                apply_filters("jankx_page_template_{$context}_data", [])
            );
        }

        /**
         * Get site footer
         */
        get_footer();
    }
}
