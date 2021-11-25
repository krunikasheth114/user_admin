<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Blog;

use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    public function blogList()
    {
        if (Auth::check()) {
            $blog = Blog::get();
            return $this->sendResponse($blog, 'Blog list');
        }
    }
}
