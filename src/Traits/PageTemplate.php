<?php
namespace Jankx\Template\Traits;

trait PageTemplate
{
    public function index()
    {
        $this->getHeader();
        do_action('before_home_content');
        $this->getContent(array('home', 'index'));
        do_action('after_home_content');
        $this->getFooter();
    }

    public function page()
    {
        $this->getHeader();
        do_action('before_page_content');
        $this->getContent('page');
        do_action('after_page_content');
        $this->getFooter();
    }

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
        ));
        do_action('after_single_content');
        $this->getFooter();
    }

    public function archive()
    {
        $this->getHeader();
        do_action('after_archive_content');
        $this->getContent(array(
            'archive'
        ));
        do_action('after_archive_content');
        $this->getFooter();
    }

    public function search()
    {
        $this->getHeader();
        do_action('after_search_content');
        $this->getContent(array(
            'search'
        ));
        do_action('after_search_content');
        $this->getFooter();
    }
}
