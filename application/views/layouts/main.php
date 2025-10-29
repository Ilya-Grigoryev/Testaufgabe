<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= html_escape($page_title ?? 'Projects'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; margin: 2rem; background: #f8f9fb; color: #1d1f24; }
        header { margin-bottom: 2rem; }
        h1 { margin: 0 0 1rem; font-size: 1.75rem; }
        a.button { display: inline-block; padding: 0.5rem 1rem; background: #1f6feb; color: #fff; border-radius: 4px; text-decoration: none; }
        a.button:hover { background: #195dc4; }
        form.filter { background: #fff; padding: 1rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
        form.filter label { display: block; margin-bottom: 0.25rem; font-weight: 600; }
        form.filter input, form.filter select { width: 100%; padding: 0.5rem; margin-bottom: 0.75rem; border: 1px solid #cbd0d8; border-radius: 4px; }
        .filters-grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        table { width: 100%; border-collapse: collapse; }
        table thead { background: #e2e8f0; }
        table th, table td { padding: 0.75rem; border-bottom: 1px solid #d1d5db; text-align: left; }
        table tbody tr:nth-child(even) { background: #f1f5f9; }
        .status { display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.85rem; font-weight: 600; }
        .status.active { background: #dcfce7; color: #166534; }
        .status.on_hold { background: #fef3c7; color: #b45309; }
        .status.archived { background: #fee2e2; color: #b91c1c; }
        .stats { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; gap: 1rem; flex-wrap: wrap; }
    </style>
</head>
<body>
<header>
    <h1><?= html_escape($page_title ?? 'Projects'); ?></h1>
</header>
<main>
    <?= $content; ?>
</main>
</body>
</html>
