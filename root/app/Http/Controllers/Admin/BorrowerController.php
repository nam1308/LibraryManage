<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\BorrowerServiceInterface;

class BorrowerController extends Controller
{
    protected $categoryService;
    protected $bookService;
    protected $borrowerService;

    public function __construct(
        CategoryServiceInterface $categoryService,
        BookServiceInterface     $bookService,
        BorrowerServiceInterface $borrowerService,
    ){
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->borrowerService = $borrowerService;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $categories = $this->categoryService->getAllCategories();
        $borrowers = $this->borrowerService->index($data)->appends($data);
        if (!empty($data)) {
            return view('admin.borrowers.table', [
                'borrowers' => $borrowers,
                'countBorrowers' => $borrowers->total(),
            ]);
        }
        return view('admin.borrowers.index',[
            'categories' => $categories,
            'borrowers' => $borrowers,
            'countBorrowers' => $borrowers->total(),
        ]);
    }
}
