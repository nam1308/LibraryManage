<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepository;
use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;

class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    use RepositoryTraits;
    public function model()
    {
        return Notification::class;
    }

    public function buildQuery($model, $filters)
    {}
}