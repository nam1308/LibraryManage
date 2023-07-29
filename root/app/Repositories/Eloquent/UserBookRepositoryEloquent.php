<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserBookRepository;
use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\UserBook;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class UserBookRepositoryEloquent extends BaseRepository implements UserBookRepository
{
    use RepositoryTraits;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserBook::class;
    }

    function buildQuery($model, $filters)
    {

    }

}