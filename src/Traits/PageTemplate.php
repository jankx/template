<?php
namespace Jankx\Template\Traits;

trait PageTemplate
{
    public function index()
    {
        $this->getHeader();
        $this->getContent(array('home', 'index'));
        $this->getFooter();
    }

    public function page()
    {
        $this->getHeader();
        $this->getContent('page');
        $this->getFooter();
    }

    public function single()
    {
        $this->getHeader();
        $this->getContent(array(
            sprintf(
                'single/%s',
                empty($this->pageType) ? get_post_type() : $this->pageType
            ),
            'single'
        ));
        $this->getFooter();
    }

    public function archive()
    {
        $this->getHeader();
        $this->getContent(array(
            'archive'
        ));
        $this->getFooter();
    }
}
