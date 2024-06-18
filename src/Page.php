<?php

/**
 * Setup Jankx page (Theme system)
 */

namespace Jankx\Template;

use Jankx;
use Jankx\Template\Template;
use Jankx\TemplateEngine\Context;

class Page
{
    protected static $instance;

    protected $context;

    protected $partialName;

    protected $templates;

    protected $loadedLayout;

    protected $isGutenbergSupport;

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


    public function getLoadedLayout()
    {
        return $this->loadedLayout;
    }

    public function setLoadedLayout($layout)
    {
        $this->loadedLayout = $layout;
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

        if (in_array($this->context, ['tax', 'author', 'date'])) {
            array_push($templates, 'archive');
        }

        array_push($templates, 'index');

        return apply_filters(
            'jankx/template/page/template_names',
            $templates,
            $this->context,
            $this->templates
        );
    }

    public function getTemplates()
    {
        if (is_null($this->templates)) {
            return [];
        }
        return $this->templates;
    }

    public function isGutenbergSupport() {
        if (is_null($this->isGutenbergSupport)) {
            $this->isGutenbergSupport = jankx_is_support_block_template();
        }
        return $this->isGutenbergSupport;
    }

    protected function renderContent($engine)
    {
        $pre = apply_filters('jankx/template/site/content/pre', null, $this->context, $this->templates);
        if (!is_null($pre)) {
            return $pre;
        }
        do_action('jankx/template/site/content/init', $this, $this->context, $this->templates);

        return $engine->render(
            $this->generateTemplateNames(),
            apply_filters("jankx/template/page/{$this->context}/data", Context::get()),
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
        do_action('jankx/template/render/start', $this);

        $engine = Template::getEngine(Jankx::ENGINE_ID);

        if (!$engine->isDirectRender()) {
            return $engine->render(
                $this->generateTemplateNames(),
                apply_filters("jankx/template/page/{$this->context}/data", Context::get())
            );
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


        if ($this->isGutenbergSupport()) {
            echo get_the_block_template_html();
        } else {
            echo $this->renderContent($engine);
        }

        do_action('jankx/template/page/content/after', $context, $this->templates);

        get_footer(
            apply_filters(
                'jankx/template/page/footer/name',
                null,
                $this->templates,
                $this->context
            )
        );

        do_action('jankx/template/render/start', $this);
    }
}
