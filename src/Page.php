<?php
namespace Jankx\Template;

use Jankx;
use Jankx\Template\Template;

class Page
{
    protected static $instance;

    protected $context;
    protected $templates;

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

    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    public function generateTemplateNames()
    {
        if (empty($this->templates)) {
            return $this->context;
        }
        return $this->templates;
    }

    protected function renderContent($engine) {
        $templateHook = sprintf(
            'jankx_template_page_%s%s',
            $this->context,
            $this->partialName ? '_' . $this->partialName : ''
        );

        if (has_action($templateHook)) {
            return do_action($templateHook, $this->context, $this->partialName);
        }

        $engine->render(
            $this->generateTemplateNames(),
            apply_filters("jankx_template_page_{$this->context}_data", [])
        );
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

        if (!$engine->isDirectRender()) {
            return $engine->render($this->generateTemplateNames());
        }

        /**
         * Get site header
         */
        get_header($this->partialName ? $this->partialName : $this->context);

        // Setup post data
        if (is_singular()) {
            the_post();
        }

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

        do_action('jankx_template_before_content', $context, $this->partialName);

        $this->renderContent($engine);

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
