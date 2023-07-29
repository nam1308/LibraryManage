<?php

namespace App\Services\Contracts;

interface ReflectionServiceInterface
{
    public function show($request);
    public  function totalBookReflection($bookId);
    public function getAverageStarByBookId($bookId);
}