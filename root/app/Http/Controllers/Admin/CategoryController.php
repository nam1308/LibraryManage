<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Parameter
     *
     * @var CategoryServiceInterface
     */
    protected $CategoryService;

    /**
     * CategoryServiceInterface constructor.
     *
     * @param CategoryServiceInterface $CategoryServiceInterface
     */
    public function __construct(CategoryServiceInterface $CategoryService)
    {
        $this->CategoryService = $CategoryService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $categories = $this->CategoryService->index($data);
        if (!empty($data)) {
            $categories = $this->CategoryService->index($data)->appends($data);
            return view('admin.categories.table', [
                'categories' => $categories,
                'status' => $request['status'],
            ]);
        }
        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        try {
            $category = $this->CategoryService->store($data);
            if (!$category) {
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thêm thể loại thất bại!']);
            }
            DB::commit();
            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Thêm thể loại thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thêm thể loại thất bại!']);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
        return response()->json(['category' => $this->CategoryService->show($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        DB::beginTransaction();
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        try {
            $category = $this->CategoryService->update($data, $id);
            if (!$category) 
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thể loại đã được sử dụng!']);
            DB::commit();
            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Chỉnh sửa thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Chỉnh sửa thất bại!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = $this->CategoryService->destroy($id);
            if (!$category) 
                return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Thể loại đã được sử dụng!']);
            DB::commit();
            return response()->json(['status' => config('constants.ERROR_STATUS.SUCCESS'), 'message' => 'Xoá thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => config('constants.ERROR_STATUS.FAIL'), 'message' => 'Xóa thất bại!']);
        }
    }
}