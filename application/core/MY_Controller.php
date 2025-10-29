<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $pageTitle = 'Projects';

    protected function render(string $view, array $data = [], ?string $title = null): void
    {
        $content = $this->load->view($view, $data, TRUE);

        $this->load->view('layouts/main', array_merge($data, [
            'content' => $content,
            'page_title' => $title ?? $this->pageTitle,
        ]));
    }
}
