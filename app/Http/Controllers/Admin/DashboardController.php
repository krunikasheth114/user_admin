<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Like;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDashboared()
    {
        $users=User::count();
        $total_blog=Blog::count();
        $blogs = Blog::latest('created_at')->take(5)->get()->pluck(['title']);
        $likes = DB::table('likes')->select('blog_id', DB::raw('count(*) as total'))->groupBy('blog_id')->get()->pluck('total');
    
        return view('admin.dashboard.index', compact('blogs', 'likes','users','total_blog'));
    }
}
