<?php

namespace App\Services\Contracts;

interface UserServiceInterface
{
    public function getUser();
    public function index($request);

    public function store($request);

    public function showUser($id);

    public function editInfoUser($request);

    public function show($id);

    public function update($request, $id);

    public function block($request);

    public function changePasswordUser($request);

    public function changePassword($request, $id);

    public function forgotPassword($request);

    public function updateIsFirst($id);

    public function destroy($request);

    public function unBlock($request);
    
    public function getStatistic($filters, $relation = [], $column = ['*']);

    public function getTopStatistic($startDate, $endDate, $limit);
}
