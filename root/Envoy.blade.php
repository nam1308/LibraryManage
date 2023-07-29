@servers(['web' => 'olive_consulting@10.0.0.50'])

@story('deploy')
    pull_code
@endstory

@task('pull_code', ['on' => 'web'])
    cd olive_be
    echo 'pull code'
    git pull origin develop
    docker-compose exec -T php composer install
    docker-compose exec -T php php artisan migrate
    docker-compose exec -T php php artisan optimize:clear
@endtask