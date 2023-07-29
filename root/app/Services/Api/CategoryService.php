<?php

namespace App\Services\Api;

use App\Enums\CategoryEnums;
use App\Services\Contracts\CategoryServiceInterface;
use App\Repositories\Contracts\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($request)
    {
        return $this->repository->paginateByFilters(
            ['status' => @$request['status'], 'search' => @$request['search']],
            config('constants.DEFAULT_PAGINATION'),
            [],
            ['updated_at' => 'desc', 'category_cd' => 'desc']
        );
    }

    public function getCategory()
    {
        return $this->repository->where('status', CategoryEnums::STATUS_ACTIVE)
            ->withCount(['books' => function ($query) {
                $query->withTrashed();
            }])
            ->orderByDesc('books_count')
            ->orderBy('name')
            ->get(['id', 'name', 'books_count']);
    }

    public function getCategoryUser($countBook = null)
    {
        if ($countBook == 'COUNT_BOOK') {
            $ct = $this->repository->withCount('books')->orderBy('books_count', 'DESC')->orderBy('name', 'asc')->get();
            return $ct;
        }
        return $this->repository->pluck('name', 'id');
    }


    public function store($request)
    {
        return $this->repository->create($request);
    }

    public function show($id)
    {
        return $this->repository->find($id, ['category_cd', 'name', 'status', 'note']);
    }

    public function update($request, $id)
    {
        if (count($this->repository->firstById($id, 'books')->books) != 0 && $request['status'] == CategoryEnums::STATUS_INACTIVE) return NULL;
        return $this->repository->update($request, $id);
    }

    public function destroy($id)
    {
        if (count($this->repository->firstById($id, 'books')->books) != 0) return NULL;
        return $this->repository->delete($id);
    }
    public function categoryActive()
    {
        return $this->repository->where('status',CategoryEnums::STATUS_ACTIVE)->pluck('name','id');
    }

    public function getAllCategories()
    {
        return $this->repository->withCount(['books' => function ($query) {
                $query->withTrashed(); }])
            ->orderBy('name')
            ->pluck('name', 'id');
    }
}