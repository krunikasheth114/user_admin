<?php
function isLike($blog_id)
{
    $blog = \App\Models\Like::where('blog_id',$blog_id)->where('user_id',Auth::user()->id)->first();

    if(!empty($blog)) {
        return true;
    }
     return false;
}

function getblogView($blog_id) {
     $view = \App\Models\View::where('blog_id',$blog_id)->count();
     return $view;
}
