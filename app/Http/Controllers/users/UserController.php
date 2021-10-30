<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\usersUsersDataTable;

class UserController extends Controller
{
    public function dataTable(UsersDataTable $datatable)
    {
        
        return $datatable->render('user.index');
    }
}