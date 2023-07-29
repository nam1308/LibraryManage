<?php

namespace App\Services\Contracts;

interface CategoryServiceInterface
{
    public function index($request);

    public function getCategory();

    public function categoryActive();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function getCategoryUser($countBook = null);

    public function destroy($id);

    public function getAllCategories();
}