<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model');
        $this->load->helper(['url', 'form', 'project_csv', 'download']);
    }

    public function index(): void
    {
        $filters = $this->collectFilters();
        $totalProjects = $this->Project_model->count_projects($filters);
        $projects = $this->Project_model->get_projects($filters);

        $data = [
            'projects' => $projects,
            'total' => $totalProjects,
            'filters' => $filters,
            'statuses' => $this->Project_model->get_allowed_statuses(),
        ];

        $this->render('projects/index', $data, 'Projects overview');
    }

    public function export(): void
    {
        $filters = $this->collectFilters();
        $projects = $this->Project_model->get_projects($filters, null, ['created_at' => 'DESC']);

        $filename = 'projects_' . date('Ymd_His') . '.csv';
        $csvContent = build_projects_csv($projects);

        force_download($filename, $csvContent);
    }

    private function collectFilters(): array
    {
        $status = $this->input->get('status', TRUE);
        $search = trim((string) $this->input->get('search', TRUE));
        $budgetMin = $this->normalizeDecimal($this->input->get('budget_min', TRUE));
        $budgetMax = $this->normalizeDecimal($this->input->get('budget_max', TRUE));
        $createdFrom = $this->normalizeDate($this->input->get('created_from', TRUE));
        $createdTo = $this->normalizeDate($this->input->get('created_to', TRUE));

        if ($status && !in_array($status, $this->Project_model->get_allowed_statuses(), true)) {
            $status = null;
        }

        if ($budgetMin !== null && $budgetMax !== null && $budgetMin > $budgetMax) {
            [$budgetMin, $budgetMax] = [$budgetMax, $budgetMin];
        }

        if ($createdFrom && $createdTo && $createdFrom > $createdTo) {
            [$createdFrom, $createdTo] = [$createdTo, $createdFrom];
        }

        return array_filter([
            'status' => $status ?: null,
            'search' => ($search !== '') ? $search : null,
            'budget_min' => $budgetMin,
            'budget_max' => $budgetMax,
            'created_from' => $createdFrom,
            'created_to' => $createdTo,
        ], static function ($value) {
            return $value !== null;
        });
    }

    private function normalizeDecimal($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $normalized = str_replace(',', '.', (string) $value);
        return is_numeric($normalized) ? (float) $normalized : null;
    }

    private function normalizeDate($value): ?string
    {
        if (!$value) {
            return null;
        }

        $date = DateTime::createFromFormat('Y-m-d', $value);
        return $date ? $date->format('Y-m-d') : null;
    }
}
