<?php

namespace App\Repositories\Eloquent;

use App\Models\Reflection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ReflectionRepository;
use App\Repositories\Traits\RepositoryTraits;
use App\Validators\ReflectionValidator;

/**
 * Class ReflectionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ReflectionRepositoryEloquent extends BaseRepository implements ReflectionRepository
{
    use RepositoryTraits;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reflection::class;
    }
    function buildQuery($model, $filters)
    {
        if ($this->isValidKey($filters, 'filter_book_id')) {
            $model = $model->where('book_id', $filters['filter_book_id']);
        }
        if ($this->isValidKey($filters, 'vote')) {
            $model = $model->where('vote', $filters['vote']);
        }
        return $model;
    }
    public function avgStarByBookId($bookId)
    {
        return $this->model->where('book_id', $bookId)->avg('vote');
    }
    
}
