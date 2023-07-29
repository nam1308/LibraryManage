<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BorrowerRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface BorrowerRepository extends RepositoryInterface
{
    public function getColumnByFieldBetweenRange($column, $field, array $range);

    public function countTheNumberBook($request);
}
