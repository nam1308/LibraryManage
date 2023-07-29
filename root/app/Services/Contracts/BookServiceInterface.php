<?php

namespace App\Services\Contracts;

interface BookServiceInterface
{
    public function index($request);

    public function getAllBook($request);

    public function destroy($id);

    public function destroyGiver($id);

    public function show($bookId);

    public function homeUser($request);

    public function checkBookBorrowing($bookId);

    public function totalBookBorrow($bookId);
    public function getBookFromBorrower($bookId);
    public function updateBorrowerRenewal($id, $request);

    public function updateBorrowerStatus($borrowerIds);

    public function getBorrowersForUpdateStatus();

    public function store($request);
    public function bookReturnHandler($bookId, $request, $emailAdmin);

    public function details($id);

    public function fetchData($request);

    public function countBook();

    public function showEditBook($id);

    public function update($request);

    public function importFile($request);

    public function getStatistic($filters, $relation = [], $column = ['*']);

    public function getTopStatistic($startDate, $endDate, $limit);
    
    public function createReflectionBook($request);
    public function updateReflectionBook($request, $reflection_id);
    public function findReflectionBook($id_reflection);

    public function checkTotalBook($request);
    public function bookCreateNotification($book);
}
