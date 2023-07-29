<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ExampleRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface NotificationRepository extends RepositoryInterface
{
    public function model();
}
