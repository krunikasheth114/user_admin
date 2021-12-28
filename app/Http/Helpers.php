<?php
function isLike($blog_id)
{
    $blog = \App\Models\Like::where('blog_id', $blog_id)->where('user_id', Auth::user()->id)->first();

    if (!empty($blog)) {
        return true;
    }
    return false;
}

function getblogView($blog_id)
{
    $view = \App\Models\View::where('blog_id', $blog_id)->count();
    return $view;
}

function getChildComment($comment_id)
{
    $comments = \App\Models\Comment::where('parent_id', $comment_id)->get();

    return $comments;
}

function getEuroPrice($price)
{
    $from = 'INR';
    if ($from == 'INR') {

        $to = 'EUR';
        $newPrice = Currency::convert()
            ->from($from)
            ->to($to)
            ->amount($price)
            ->get();
    }
    return $newPrice;
}


// function getProduct($category_id){
//     $data[] = Product::with('getCategory')->where('category_id', '=', $category_id)->get();
// }