<?php

namespace App\Services\Api;

use App\Services\Contracts\AdminServiceInterface;
use App\Traits\FileTrait;
use App\Repositories\Contracts\AdminRepository;
class AdminService implements AdminServiceInterface
{

    /**
     * @var AdminRepository
     */
    protected $repository;

    public function __construct(AdminRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getEmail()
    {
        return $this->repository->pluck('email');
    }

}
