<?php

namespace App\Services\Api;

use App\Services\Contracts\ReflectionServiceInterface;
use App\Repositories\Contracts\ReflectionRepository;

class ReflectionService implements ReflectionServiceInterface
{

    /**
     * @var ReflectionRepository
     */
    protected $repository;

    public function __construct(ReflectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show($request)
    {
        if (@$request['vote'] === "all") {
            @$request['vote'] = null;
        }
        $filters = [
            'vote' => @$request['vote'],
            'filter_book_id' => @$request['filter_book_id'],
        ];
        return $this->repository->paginateByFilters(
            $filters,
            config('constants.DEFAULT_PAGINATION'),
            ['users:id,name'],
            ['created_at' => 'desc']);
    }

    public function totalBookReflection($bookId)
    {
        return $this->repository->countByFilters(
           ['filter_book_id' => $bookId]
        );
    }

    public function getAverageStarByBookId($bookId)
    {
        $avgStar = $this->repository->avgStarByBookId($bookId);
        return round($avgStar, 1);
    }

}
