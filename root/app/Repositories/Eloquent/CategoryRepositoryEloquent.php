<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CategoryRepository;
/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    use RepositoryTraits;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    function buildQuery($model, $filters)
    {
        // TODO: Implement buildQuery() method.
        if ($this->isValidKey($filters, 'status')) {
            $model = $model->where('status', $filters['status']);
        }

        if ($this->isValidKey($filters, 'search')) {
            $model = $model->where(function ($query) use ($filters) {
                $query->orWhere('category_cd', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $model;
    }
}