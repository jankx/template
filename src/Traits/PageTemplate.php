<?php
/**
 * Jankx template engine methods
 *
 * @package UI
 */

namespace Jankx\Template\Traits;

trait PageTemplate
{
    /**
     * Load the home or index template
     */
    public function index()
    {
        $this->getHeader();
        do_action('before_home_content');
        $this->getContent(array('home', 'index'), 'home');
        do_action('after_home_content');
        $this->getFooter();
    }

    /**
     * Load the page template
     */
    public function page()
    {
        $this->getHeader();
        do_action('before_page_content');
        $this->getContent('page', 'page');
        do_action('after_page_content');
        $this->getFooter();
    }

    /**
     * Load the single post template
     */
    public function single()
    {
        $this->getHeader();
        do_action('before_single_content');
        $this->getContent(array(
            sprintf(
                'single/%s',
                empty($this->pageType) ? get_post_type() : $this->pageType
            ),
            'single'
        ), 'single');
        do_action('after_single_content');
        $this->getFooter();
    }

    /**
     * Load the archive template
     */
    public function archive()
    {
        $this->getHeader();
        do_action('after_archive_content');
        $this->getContent(array(
            sprintf(
                'archive/%s',
                empty($this->pageType) ? get_post_type() : $this->pageType
            ),
            'archive'
        ), 'archive');
        do_action('after_archive_content');
        $this->getFooter();
    }

    /**
     * Load the search result template
     */
    public function search()
    {
        $this->getHeader();
        do_action('after_search_content');
        $this->getContent(array(
            sprintf(
                'search/%s',
                get_post_type()
            ),
            'search'
        ), 'search');
        do_action('after_search_content');
        $this->getFooter();
    }

    /**
     * This method to load the template in contain in theme directory
     * Them like Woocommerce template or similar template
     */
    public function autoload()
    {
        require_once $this->templateFile;
    }
}
