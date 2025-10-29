<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->input->is_cli_request()) {
            show_error('Migrations can only be run from the CLI.', 403);
        }

        $this->load->library('migration');
    }

    public function index(): void
    {
        $this->latest();
    }

    public function latest(): void
    {
        $result = $this->migration->latest();

        if ($result === FALSE) {
            show_error($this->migration->error_string(), 500);
        }

        echo "Migrations completed." . PHP_EOL;
    }
}
