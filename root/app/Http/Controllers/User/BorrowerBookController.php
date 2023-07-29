<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Contracts\AdminServiceInterface;
use App\Services\Contracts\BorrowerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowerBookController extends Controller
{
	protected $borrowerService;
	protected $adminService;
	public function __construct(BorrowerServiceInterface $borrowerService, AdminServiceInterface $adminService)
	{
		$this->borrowerService = $borrowerService;
		$this->adminService = $adminService;
	}

	public function borrowBook(Request $request, $bookId)
	{
        $emailAdmin=$this->adminService->getEmail();
		DB::beginTransaction();
		try {
		$this->borrowerService->borrowBook($request,$bookId,$emailAdmin);
		DB::commit();
		return response()->json([
			'status' => 200,
			'title' => 'Thành công',
			'message' => 'Bạn đã mượn sách thành công!',
		]);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => $e->getCode(),
				'title' => 'Lỗi',
				'message' => $e->getMessage(),
			]);
		}
	}
}
