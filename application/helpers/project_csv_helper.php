<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('build_projects_csv')) {
    /**
     * Build a CSV string for the provided project rows.
     */
    function build_projects_csv(array $projects): string
    {
        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Name', 'Budget', 'Status', 'Created at', 'Updated at']);

        foreach ($projects as $project) {
            fputcsv($handle, [
                $project['id'] ?? '',
                $project['name'] ?? '',
                number_format((float) ($project['budget'] ?? 0), 2, '.', ''),
                $project['status'] ?? '',
                $project['created_at'] ?? '',
                $project['updated_at'] ?? '',
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle) ?: '';
        fclose($handle);

        return $csv;
    }
}
