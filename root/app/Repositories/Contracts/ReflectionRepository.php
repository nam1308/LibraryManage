<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ReflectionRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface ReflectionRepository extends RepositoryInterface
{
    public function model();
}
