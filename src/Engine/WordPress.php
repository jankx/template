<?php

namespace Jankx\Template\Engine;

use Jankx\Template\EngineAbstract;

class WordPress extends EngineAbstract
{
    protected $defaultDirectory = 'default';

    public function templateExtension()
    {
        return apply_filters(
            'jankx_template_engine_wordpress_extension',
            '.php'
        );
    }

    public function getDefaultTemplateDirectory($fileInRoot)
    {
        $rootDir = str_replace(get_template_directory(), '', dirname($fileInRoot));
        return apply_filters(
            'jankx_template_engine_wordpress_default_directory',
            sprintf('%s/default', ltrim($rootDir, '/'))
        );
    }

    public function loadTemplates($templates, $loadTemplate = true, $require_once = false)
    {
        /**
         * Use WordPress native function to search template and include if needed
         */
        return locate_template($templates, $loadTemplate, $require_once);
    }

    public function index()
    {
    }
}
