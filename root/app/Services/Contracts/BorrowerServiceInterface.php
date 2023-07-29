<?php

namespace App\Services\Contracts;

interface BorrowerServiceInterface
{
    public function getallByUser($user ,$request);

    public function borrowBook($request,$bookId,$emailAdmin);
    public function countBetweenDayRange($startDate, $endDate, $status);

    public function getStatistic($startDate, $endDate);

    public function index($request);

    public function getOverDue();

    public function updateMultipleStatus($updateIds, $status);

    public function countTotalBook($bookId, $status);

    public function countNewBorrower($startDate, $endDate);
}