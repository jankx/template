<?php
namespace Jankx\Template;

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

    /**
     * The main template render
     *
     * @param string $context Create the action hook via render context
     * @return void
     */
    public function render()
    {
        /**
         * Get site header
         */
        get_header($this->partialName ? $this->partialName : $this->context);

        // Setup post data
        if (is_singular()) {
            the_post();
        }
        do_action('jankx_template_init_page');

        $context = $this->context;
        if (empty($this->partialName)) {
            if ($context === 'single') {
                $this->partialName = get_post_type();
            } elseif ($context === 'taxonomy') {
                $context = 'archive';
                $queried_object = get_queried_object();
                $this->partialName = $queried_object->taxonomy;
            }
        }

        $templateHook = sprintf('jankx_template_page_%s_%s', $context, $this->partialName);

        do_action('jankx_template_before_content', $context, $this->partialName);
        if (has_action($templateHook)) {
            do_action($templateHook, $context, $this->partialName);
        } else {
            $templates = [];

            if ($this->partialName != '') {
                $templates[] = sprintf('%s/%s', $context, $this->partialName);
                $templates[] = sprintf('%s-%s', $context, $this->partialName);
            }
            $templates[] = $context;

            jankx_template(
                $templates,
                apply_filters("jankx_template_page_{$context}_data", [])
            );
        }
        do_action('jankx_template_after_content', $context, $this->partialName);

        $footerActiveStatus = apply_filters('jankx_is_active_footer', true, $this);
        if ($footerActiveStatus) {
            $footerName = $this->partialName ? $this->partialName : $this->context;
        } else {
            $footerName = 'blank';
        }
        get_footer($footerName);
    }
}
