<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_ON_HOLD = 'on_hold';
    public const STATUS_ARCHIVED = 'archived';

    private const TABLE = 'projects';

    /**
     * @var string[]
     */
    private $allowedStatuses = [
        self::STATUS_ACTIVE,
        self::STATUS_ON_HOLD,
        self::STATUS_ARCHIVED,
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_allowed_statuses(): array
    {
        return $this->allowedStatuses;
    }

    public function get_projects(array $filters = [], ?array $pagination = null, ?array $sorting = null): array
    {
        $builder = $this->db->select('id, name, budget, status, created_at, updated_at')
            ->from(self::TABLE);

        $this->applyFilters($builder, $filters);

        if ($sorting) {
            foreach ($sorting as $column => $direction) {
                $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
                $builder->order_by($column, $direction);
            }
        } else {
            $builder->order_by('created_at', 'DESC');
            $builder->order_by('id', 'DESC');
        }

        if ($pagination) {
            $limit = (int) ($pagination['limit'] ?? 0);
            $offset = (int) ($pagination['offset'] ?? 0);
            if ($limit > 0) {
                $builder->limit($limit, max($offset, 0));
            }
        }

        return $builder->get()->result_array();
    }

    public function count_projects(array $filters = []): int
    {
        $builder = $this->db->from(self::TABLE);
        $this->applyFilters($builder, $filters);
        return (int) $builder->count_all_results();
    }

    private function applyFilters(CI_DB_query_builder $builder, array $filters): void
    {
        if (!empty($filters['status']) && in_array($filters['status'], $this->allowedStatuses, true)) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $builder->like('name', $filters['search']);
        }

        if (isset($filters['budget_min'])) {
            $builder->where('budget >=', (float) $filters['budget_min']);
        }

        if (isset($filters['budget_max'])) {
            $builder->where('budget <=', (float) $filters['budget_max']);
        }

        if (!empty($filters['created_from'])) {
            $builder->where('created_at >=', $filters['created_from'] . ' 00:00:00');
        }

        if (!empty($filters['created_to'])) {
            $builder->where('created_at <=', $filters['created_to'] . ' 23:59:59');
        }
    }
}
