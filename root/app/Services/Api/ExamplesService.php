<?php

namespace App\Services\Api;

use App\Services\Contracts\ExamplesServiceInterface;
use App\Repositories\Contracts\ExampleRepository;

class ExamplesService implements ExamplesServiceInterface
{
    /**
     * @var ExampleRepository
     */
    protected $repository;

    /**
     * ExamplesController constructor.
     *
     * @param ExampleRepository $repository
     */
    public function __construct(ExampleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($request)
    {
        $relationship = [];
        $orderBy = ['id' => "ASC"];
        $limit = 20;
        $offset = 0;
        $pageSize = 20;


        // Get the first record
        $data = $this->repository->firstByWhere(['id' => 1], $relationship);

        // Get records according to query conditions with limit, offset
        $data1 = $this->repository->getByFilters(['name' => "Customer"], $relationship, $limit, $offset, $orderBy);

        // Get all records according to the query condition
        $data2 = $this->repository->getAllByFilters(['name_like' => "Customer"], $relationship, $orderBy);

        // Get the first record according to the query condition
        $data3 = $this->repository->firstByFilters(['name_like' => "Customer"], $relationship, $orderBy);

        // Get all the records according to the query condition with the page
        $data4 = $this->repository->setPresenter("App\\Presenters\\ExamplePresenter")->paginateByFilters(
            [],
            $pageSize,
            $relationship,
            $orderBy
        );

        return $data4['data'];
    }

    public function store($request)
    {
        $value = $request->all();
        return $this->repository->create($value);
    }
}
