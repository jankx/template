<?php

namespace Jankx\Template\Engine;

use Jankx\Template\Abstracts\TemplateEngine;

class WordPress extends TemplateEngine
{
    protected $defaultDirectory = 'default';

    public function templateExtension()
    {
        return apply_filters(
            'jankx_template_engine_wordpress_extension',
            '.php'
        );
    }

    public function getDefaultTemplateDirectory()
    {
        $rootDir = realpath(dirname(__FILE__) . str_repeat('/..', 2));
        return apply_filters(
            'jankx_template_engine_wordpress_default_directory',
            sprintf('%s/default', $rootDir)
        );
    }

    public function loadTemplates($templates, $loadTemplate = true, $require_once = false)
    {
        /**
         * Use WordPress native function to search template and include if needed
         */
        $searched_template = locate_template(
            $this->searchTemplates($templates),
            false
        );

        if (empty($searched_template)) {
            $defaultDirectory = $this->getDefaultTemplateDirectory();
            foreach ((array)$templates as $template) {
                $template = sprintf('%s/%s.php', $defaultDirectory, $template);
                if (file_exists($template)) {
                    $searched_template = $template;
                    break;
                }
            }
        }

        if (!$searched_template || !$loadTemplate) {
            return $searched_template;
        }
        if ($require_once) {
            require_once $temsearched_templateplate;
        } else {
            require $searched_template;
        }
    }
}
