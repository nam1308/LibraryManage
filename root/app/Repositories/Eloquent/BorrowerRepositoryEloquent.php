<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\BorrowerRepository;
use App\Repositories\Traits\RepositoryTraits;
use App\Models\Borrower ;
use App\Validators\BorrowerValidator;
use Illuminate\Support\Facades\DB;
use App\Enums\BorrowerEnums;

/**
 * Class BorrowerRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BorrowerRepositoryEloquent extends BaseRepository implements BorrowerRepository
{
    use RepositoryTraits;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Borrower::class;
    }

    public function buildQuery($model, $filters)
    {
        if ($this->isValidKey($filters, 'search')) {
            $model = $model->whereHas('book', function ($query) use ($filters) {
                $query->where('book_cd', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('author', 'like', '%' . $filters['search'] . '%');
            });
        }

        if($this->isValidKey($filters, 'categories')) {
            $categoryId = $filters['categories'];
            $model = $model->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId)
                    ->with('book:id,name,book_cd', 'users:id,name');
            });
        }

        if ($this->isValidKey($filters, 'status')) {
            if (is_array($filters['status'])) {
                $model = $model->whereIn('status', $filters['status']);
            } else {
                $model = $model->where('status', $filters['status']);
            }
        }

        if ($this->isValidKey($filters, 'notStatus')) {
            if (is_array($filters['notStatus'])) {
                $model = $model->whereNotIN('status', $filters['notStatus']);
            } else {
                $model = $model->where('status', '!=', $filters['notStatus']);
            }
        }

        if ($this->isValidKey($filters, 'book_id')) {
            $model = $model->where('book_id', $filters['book_id']);
        }
        if ($this->isValidKey($filters, 'now')) {
            $model = $model->where('to_date','<', $filters['now']);
        }

        if ($this->isValidKey($filters, 'user_id')) {
            $model = $model->where('user_id', $filters['user_id']);
        }

        if($this->isValidKey($filters, 'searchAdmin')) {
            $model = $model->where(function ($query) use ($filters) {
                $query->orWhereHas('book', function ($query) use ($filters) {
                    $query->where('books.book_cd', 'like', '%' . $filters['searchAdmin'] . '%')
                        ->orWhere('books.name', 'like', '%' . $filters['searchAdmin'] . '%');
                })->orWhereHas('users', function ($query) use ($filters) {
                    $query->where('users.name', 'like', '%' . $filters['searchAdmin'] . '%');
                });
            });
        }

        if($this->isValidKey($filters, 'overdue')) {
            $model = $model->where(function ($query) {
                    $query->whereNull('extended_date')
                        ->whereDate('to_date', '<', DB::raw('CURDATE()'));
                })
                ->orWhere(function ($query) {
                    $query->whereDate('extended_date', '<', DB::raw('CURDATE()'));
            });
        }

        if ($this->isValidKey($filters, 'between_column') && $this->isValidKey($filters, 'between_date')) {
            $model = $model->whereBetween($filters['between_column'], $filters['between_date']);
        }

        return $model;
    }

    private function buildRelationShip($model, $relationship = [])
    {
        if (!empty($relationship)) {
            foreach ($relationship as $with) {
                $model = $model->with([$with => function ($qr) {
                    $qr->withTrashed();
                }]);
            }
        }

        return $model;
    }

    public function getColumnByFieldBetweenRange($column, $field, array $range)
    {
        return $this->select($column, DB::raw('count(id) as total'))
            ->groupBy($column)
            ->whereBetween($field, $range)
            ->pluck( 'total', 'status');
    }

    public function countTheNumberBook($request){
        return $this->model->where('book_id', $request)
            ->whereIn('status', [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND])
            ->count();
    }
}
