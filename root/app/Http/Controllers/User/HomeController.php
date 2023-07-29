<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Contracts\BookServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $bookService;
    protected $categoryService;
    public function __construct(BookServiceInterface $bookService, CategoryServiceInterface $categoryService)
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
    }
    public function homeUser(Request $request)
    {
        $count = $this->bookService->countBook();
        $data = $request->all();
        $books = $this->bookService->homeUser($data);
        $categories = $this->categoryService->getCategoryUser('COUNT_BOOK');
        if (!empty($data)) {
            $books = $this->bookService->homeUser($data)->appends($data);
            return view('users.home.book', [
                'books' => $books,
            ]);
        }
        return view('users.home.index', [
            'books' => $books,
            'categories' => $categories,
            'count' => $count,
        ]);
    }

}
