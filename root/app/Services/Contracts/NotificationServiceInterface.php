<?php

namespace App\Services\Contracts;

interface NotificationServiceInterface
{

public function markRead($id);
public function markReadAll($userID);

}