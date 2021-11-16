<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('CheckStatus');
    }

    public function index()
    {
        if (Auth::check()) {
            $blog = Blog::get();
            return view('user.index', compact('blog'));
        }
    }
}
