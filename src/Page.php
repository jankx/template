<?php
namespace Jankx\Template;

use Jankx;
use Jankx\Template\Template;
use Jankx\TemplateEngine\Context;

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
        $templates = empty($this->templates) ? $this->context : $this->templates;

        if (!is_array($templates)) {
            $templates = array($templates);
        }

        array_push($templates, 'home');

        return apply_filters(
            'jankx_template_page_template_names',
            $templates,
            $this->context,
            $this->templates
        );
    }

    public function getTemplates()
    {
        return $this->templates;
    }

    protected function renderContent($engine)
    {
        $pre = apply_filters('jankx/template/site/content/pre', null, $this->context, $this->templates);
        if (!is_null($pre)) {
            return $pre;
        }

        do_action('jankx/template/site/content/init', $this->context, $this->templates);

        return $engine->render(
            $this->generateTemplateNames(),
            apply_filters("jankx_template_page_{$this->context}_data", Context::get()),
            false
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

        if (!$engine->isDirectRender()) {
            return $engine->render($this->generateTemplateNames());
        }

        do_action('jankx/template/page/header/before', $this);

        /**
         * Get site header
         */
        get_header(
            apply_filters(
                'jankx/template/page/header/name',
                null,
                $this->templates,
                $this->context
            )
        );

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

        do_action('jankx/template/page/content/before', $context, $this->templates);

        echo $this->renderContent($engine);

        do_action('jankx/template/page/content/after', $context, $this->templates);

        get_footer(
            apply_filters(
                'jankx/template/page/footer/name',
                null,
                $this->templates,
                $this->context
            )
        );
    }
}
