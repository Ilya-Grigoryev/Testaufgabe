# Projects Modul (CodeIgniter 3)

Kleines "Projects"-Modul für CodeIgniter 3: Projektliste mit Filtern (Status, Name, Budget, Zeitraum) sowie CSV-Export unter Berücksichtigung der aktiven Filter.

## Start mit Docker
```bash
docker-compose up --build
docker-compose exec app php index.php migrate
```
Danach ist die Anwendung unter <http://localhost:8080> erreichbar!

## Struktur
```
application/
  controllers/Projects.php      # Liste & CSV-Export
  controllers/Migrate.php       # CLI-Migrationen
  core/MY_Controller.php        # Basis-Controller für Layout
  helpers/project_csv_helper.php
  migrations/001_create_projects_table.php
  models/Project_model.php
  views/layouts/main.php
  views/projects/index.php
```
