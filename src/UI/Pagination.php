<?php
namespace Jankx\Template\UI;

class Pagination
{
    protected $format;
    protected $currentPage;

    public function __construct($format = '?paged=%#%')
    {
        $this->format = $format;
        $this->currentPage = max(1, get_query_var('paged'));
        $this->big = 999999999;
        $this->base = str_replace(
            $this->big,
            '%#%',
            esc_url(get_pagenum_link($this->big))
        );
    }

    public function render()
    {
        global $wp_query;
        echo paginate_links(
            array(
            'base' => $this->base,
            'format' => $this->format,
            'current' => $this->currentPage,
            'total' => $wp_query->max_num_pages
            )
        );
    }
}
