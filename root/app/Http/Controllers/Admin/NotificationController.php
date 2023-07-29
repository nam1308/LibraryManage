<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\NotificationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    protected $notificationService;

    function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    function markRead(Request $request, $id)
    {
        $this->notificationService->markRead($id);
        $count = Auth::guard('admin')->user()->unreadNotifications->count();
        return response()->json(['success' => true, 'count' => $count]);
    }

    function markReadAll($userID, Request $request)
    {
        $this->notificationService->markReadAll($userID);
        return response()->json(['success' => true]);
    }
}
