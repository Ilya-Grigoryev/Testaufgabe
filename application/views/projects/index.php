<?php
$exportQuery = http_build_query($filters);
$exportUrl = site_url('projects/export' . ($exportQuery ? '?' . $exportQuery : ''));
?>
<div class="stats">
    <div><strong><?= (int) $total; ?></strong> projects found</div>
    <div>
        <a class="button" href="<?= $exportUrl; ?>">Export CSV</a>
    </div>
</div>

<?= form_open('projects', ['method' => 'get', 'class' => 'filter']); ?>
    <div class="filters-grid">
        <div>
            <label for="search">Search by name</label>
            <input id="search" name="search" type="text" value="<?= html_escape($filters['search'] ?? ''); ?>" placeholder="Project name...">
        </div>
        <div>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All</option>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status; ?>" <?= isset($filters['status']) && $filters['status'] === $status ? 'selected' : ''; ?>><?= ucfirst(str_replace('_', ' ', $status)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="budget_min">Budget minimum</label>
            <input id="budget_min" name="budget_min" type="number" step="0.01" value="<?= html_escape($filters['budget_min'] ?? ''); ?>" placeholder="0.00">
        </div>
        <div>
            <label for="budget_max">Budget maximum</label>
            <input id="budget_max" name="budget_max" type="number" step="0.01" value="<?= html_escape($filters['budget_max'] ?? ''); ?>" placeholder="50000.00">
        </div>
        <div>
            <label for="created_from">Created from</label>
            <input id="created_from" name="created_from" type="date" value="<?= html_escape($filters['created_from'] ?? ''); ?>">
        </div>
        <div>
            <label for="created_to">Created to</label>
            <input id="created_to" name="created_to" type="date" value="<?= html_escape($filters['created_to'] ?? ''); ?>">
        </div>
    </div>
    <div style="display:flex; gap:1rem;">
        <button type="submit" class="button" style="border:none; cursor:pointer;">Apply filters</button>
        <a class="button" style="background:#64748b" href="<?= site_url('projects'); ?>">Reset</a>
    </div>
<?= form_close(); ?>

<?php if (empty($projects)): ?>
    <p>No projects match the current filters.</p>
<?php else: ?>
    <div style="overflow-x:auto;">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= (int) $project['id']; ?></td>
                    <td><?= html_escape($project['name']); ?></td>
                    <td>€ <?= number_format((float) $project['budget'], 2, '.', ' '); ?></td>
                    <td><span class="status <?= html_escape($project['status']); ?>"><?= ucfirst(str_replace('_', ' ', $project['status'])); ?></span></td>
                    <td><?= html_escape(date('Y-m-d H:i', strtotime($project['created_at']))); ?></td>
                    <td><?= html_escape($project['updated_at'] ? date('Y-m-d H:i', strtotime($project['updated_at'])) : '—'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
