<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Contracts\BorrowerServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HistoryUserController extends Controller
{
    protected $borrowerService;
    public function __construct(BorrowerServiceInterface $borrowerService)
    {
        $this->borrowerService = $borrowerService;
    }
    public function getallByUser(Request $request)
    {  
            $userId = Auth::user()->id;
            
            $data = $request->all();
            $borrowers=$this->borrowerService->getallByUser($userId, $request);
            // dd($borrowers);
                if (!empty($data)) {
                    return view('users.table_history_user', [
                        'borrowers' => $borrowers,
                        'status' => @$data['status'],
                    ]);
                }
                return view('users.history.index', [
                    'borrowers' => $borrowers,
                    'status' => @$data['status'],
            ]);
    }
}
