# manage_library
- Phần mềm quản lý thư viện:
### Setup Guide project olive

## Step 1: clone project

## Step 2: setup docker
- [Install docker](https://docs.docker.com/compose/install/)

```
1. cp .env.example .env

2. docker-compose build

3. docker-compose up -d
```

## Step 3: setup laravel
```
1. docker exec -it container_name bash

2. mkdir storage

3. cd storage/

4. mkdir -p framework/{sessions,views,cache}

5. composer install

6. php artisan key:generate

7. php artisan migrate

8. php artisan db:seed

9. chmod 777 -R storage/

```

## Step 5: When change config queue
```
1. docker-compose dowm
2. docker-compose build
3. docker-compose up -d

OR

1. supervisorctl restart all
```

## NOTE

```
1. When change config crontab
    - cron reload

```

### Config repository
```
Link git: https://github.com/andersao/l5-repository

1. Config: <config/repository.php>
    'generator'=>[
        'basePath'=>app()->path(),
        'rootNamespace'=>'App\\',
        'paths'=>[
            'models'=>'Models',
            'repositories'=>'Repositories\\Eloquent',
            'interfaces'=>'Contracts\\Contracts',
            'transformers'=>'Transformers',
            'presenters'=>'Presenters'
            'validators'   => 'Validators',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Criteria',
        ]
    ]
    
2. To generate a repository for your Post model, use the following command
    php artisan make:repository Post
    
3. The artisan command to do the binding <Check App/Providers/RepositoryServiceProvider.php>
    php artisan make:bindings Post
    
4. Presenters
Presenters function as a wrapper and renderer for objects.
Create a Transformer using the command
    php artisan make:transformer Post
Create a Presenter using the command
    php artisan make:presenter Post
Enable it in your services with
    $this->repository->setPresenter("App\\Presenter\\PostPresenter");
How Do You Work in Laravel?

5. Routes
Use laravel Resource Controllers:
    Route::resource('examples', 'Api\ExamplesController', ['only' => ['index', 'store']]);
    
6. Controllers
You can use the 7 action methods as suggested in their documentation for Resource Controllers.
    index()
    create()
    store()
    show()
    edit()
    update()
    destroy()
    
7. Services
A Service can be a Domain Driven concept or 1-to-1 with a Model (database table)
```
