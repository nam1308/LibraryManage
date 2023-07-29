<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Contracts\NotificationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\BookEnums;

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
        if ($request->ajax()) {
            $count = Auth::guard('admin')->user()->unreadNotifications->count();
            return response()->json(['success' => true, 'count'=>$count]);
        }

        return redirect()->route('book.details', $request->bookId);
    }

    function markReadAll($userID, Request $request)
    {
        $this->notificationService->markReadAll($userID);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }
}