<?php

namespace App\Services;

class Paginator {

    public $current_page;
    public $last_page;

    protected $query_params;
    protected $page_query_key;

    /**
     * @param $current_page
     * @param $last_page
     * @param string $page_query_key : the string that should be inserted into query string for enabling pagination,
     * e.g. ?custom_page=3
     * @throws \Exception
     */
    public function __construct($current_page, $last_page, $page_query_key='page')
    {
        if (!intval($current_page) || !intval($last_page)) {
            throw new \Exception('Incorrect page number');
        }
        $this->current_page = $current_page;
        $this->last_page = $last_page;
        $this->page_query_key = $page_query_key;
    }

    public function getPaginationLinks()
    {
        $links = [
            'next' => $this->appendToURL($this->current_page + 1),
            'prev' => $this->appendToURL($this->current_page - 1),
            'first' => $this->appendToURL(1),
            'last' => $this->appendToURL($this->last_page),
        ];
        if ($this->current_page == $this->last_page) {
            $links['next'] = $links['last'];
        }
        if ($this->current_page == 1) {
            $links['prev'] = $links['first'];
        }
        return $links;
    }

    /**
     * @param $page_num
     * @return string
     */
    protected function appendToURL($page_num)
    {
        parse_str($_SERVER['QUERY_STRING'], $parsed_uri);
        if (isset($parsed_uri[$this->page_query_key])) {
            unset($parsed_uri[$this->page_query_key]);
        }
        $parsed_uri[$this->page_query_key] = $page_num;
        $appended = $_SERVER['SCRIPT_URI'] . '?' . http_build_query($parsed_uri);
        return $appended;
    }

} 