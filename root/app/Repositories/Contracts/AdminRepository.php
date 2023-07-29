<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AdminRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface AdminRepository extends RepositoryInterface
{
    public function model();
}
