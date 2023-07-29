<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function download($filename)
    {
        try {
            $filePath = public_path('files/csv/' . $filename);
            $filePath = realpath($filePath);
            if (file_exists($filePath)) {
                return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Tải file thành công !']);
            } else {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Không tìm thấy file !']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Tải file thất bại !']);
        }
    }
}
