<?php

namespace App\Repositories\Eloquent;

use App\Enums\BookEnums;
use App\Enums\BorrowerEnums;
use App\Models\Book;
use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\BookRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */

class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    use RepositoryTraits;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    public function buildQuery($model, $filters)
    {
        if($this->isValidKey($filters, 'search')) {
            $model = $model->where(function ($query) use ($filters) {
                $query->orWhere('book_cd', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('author', 'like', '%' . $filters['search'] . '%');
            });
        }

        if($this->isValidKey($filters, 'categories')) {
            $categoryId = $filters['categories'];
            $model = $model->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        if ($this->isValidKey($filters, 'borrowers')) {
            $model = $model->withCount(['borrowers' => function ($query) use ($filters) {
                $query->whereIn('book_id', $filters['borrowers']);
            }]);
        }

        if($this->isValidKey($filters, 'borrower_count')) {
            $model = $model->withCount(['borrowers' => function ($query) {
                $query->whereIn('status', [BorrowerEnums::STATUS_ACTIVE, BorrowerEnums::STATUS_EXTEND]);
            }]);
        }

        if($this->isValidKey($filters, 'deleted_at')) {
            $model = $model->withTrashed();
        }

        if ($this->isValidKey($filters, 'book_id')) {
            $model = $model->whereHas('categories', function ($query) use ($filters) {
                $query->where('book_id',$filters['book_id']);
            });
        }

        if ($this->isValidKey($filters, 'field_between') && $this->isValidKey($filters, 'range')){
            $model = $model->whereBetween($filters['field_between'], $filters['range']);
        }

        return $model;
    }

    public function getTopBooksByBorrowerCountBetweenDates($startDate, $endDate, $limit)
    {
        $query = $this->model
            ->join('borrowers as a', 'books.id', '=', 'a.book_id')
            ->join(DB::raw("(select book_id, count(id) as totalByBetween 
                            from borrowers 
                            where from_date between '$startDate' and '$endDate' 
                            and borrowers.deleted_at is NULL 
                            group by book_id) as b"), 'a.book_id', '=', 'b.book_id')
            ->select('books.id', 'books.name', 'b.totalByBetween', DB::raw('count(a.quantity) as totalQuantity'))
            ->groupBy('a.book_id')
            ->orderBy('b.totalByBetween', 'desc')
            ->take($limit)
            ->get();

        return $query;
    }
}