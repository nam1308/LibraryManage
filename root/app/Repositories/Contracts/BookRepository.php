<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface BookRepository extends RepositoryInterface
{
    public function getTopBooksByBorrowerCountBetweenDates($startDate, $endDate, $limit);
}