<?php

namespace App\Services\Api;

use App\Services\Contracts\NotificationServiceInterface;
use App\Repositories\Contracts\NotificationRepository;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @var NotificationRepository
     */
    protected $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function markRead($id)
    {
        $this->repository->update(['read_at' => now()],$id);
    }

    public function markReadAll($userID)
    {
        $this->repository->updateByFilters(['notifiable_id' => $userID],['read_at' => now()]);
    }
}
