<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    use RepositoryTraits;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    function buildQuery($model, $filters)
    {
        if ($this->isValidKey($filters, 'status')) {
            $model = $model->where('status', $filters['status']);
        }

        if ($this->isValidKey($filters, 'search')) {
            $model = $model->where(function ($query) use ($filters) {
                $query->orWhere('employee_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        if ($this->isValidKey($filters, 'field') && $this->isValidKey($filters, 'range')){
            $model = $model->whereBetween($filters['field'], $filters['range']);
        }

        if($this->isValidKey($filters, 'withTrashed')) {
            $model = $model->withTrashed();
        }

        return $model;
    }

    public function getTopUsersByBookQuantityBetweenDates($startDate, $endDate, $limit)
    {
        $query = $this->model
            ->join('user_book as a', 'users.id', '=', 'a.user_id')
            ->join(DB::raw("(select user_id, sum(quantity) as totalQuantityByBetween, count(id) as totalTimesByBetween 
                            from user_book 
                            where created_at between '$startDate' and '$endDate' 
                            and user_book.deleted_at is NULL 
                            group by user_id) as b"), 'a.user_id', '=', 'b.user_id')
            ->select('users.id', 'users.name', 'b.totalTimesByBetween', 'b.totalQuantityByBetween', DB::raw('sum(a.quantity) as totalQuantity'))
            ->groupBy('a.user_id')
            ->orderBy('b.totalQuantityByBetween', 'desc')
            ->take($limit)
            ->get();

        return $query;
    }
}