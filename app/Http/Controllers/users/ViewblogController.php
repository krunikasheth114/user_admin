<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;
use App\Models\Comment;
use App\Models\View;
use Illuminate\Support\Facades\URL;

class ViewblogController extends Controller
{
    public function index(Request $request, $slug)
    {

        $view = Blog::where('slug', $slug)->first();
        $url    = URL::current();
        $visit = View::create(['blog_id' => $view->id, 'ip' => $request->ip(), 'url' => $url]);
        $comments = Comment::where('blog_id', $view->id)
            ->where('parent_id', '=', 0)->get();
        return view('user.blog.viewblog', compact('view', 'visit', 'comments'));
    }
    public function like(Request $request)
    {
        $like = Like::where('blog_id', $request->id)->where('user_id', \Auth::user()->id)->first();

        if (empty($like)) {
            $like = Like::create(['blog_id' => $request->id, 'user_id' => \Auth::user()->id]);

            return response()->json(['status' => true, 'data' => $like]);
        } else {
            $like->delete();

            return response()->json(['status' => false, 'data' => '']);
        }
    }
    public function comment(Request $request)
    {
        $comment = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment]);
        return redirect()->back();
    }
    public function delete(Request $request)
    {

        $delete = Comment::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete]);
    }
    public function commentReply(Request $request)
    {
        // dd($request->all());
        $commentRep = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment_reply, 'parent_id' => $request->parent_id]);
        return redirect()->back();
    }
    public function response(Request $request)
    {

        $commentRes = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment, 'parent_id' => $request->parent_id]);
        return response()->json(['status' => true, 'data' => $commentRes]);
    }
    public function fetchComment(Request $request)
    {
        $comments = Comment::where('blog_id', $request->blog_id)->where('parent_id', 0)->get();
        $output = '';
        for ($i = 0; $i < count($comments); $i++) {
            $output .= '<div class="sidebar-item comments">
                                <div class="sidebar-heading">
                                </div>
                            <div class="content">
                            <ul>';
            $output .= '<li>
                                <div class="right-content">
                                   <h5> <b>@</b>' . $comments[$i]->getUser->firstname . '  ' . $comments[$i]->created_at->diffForHumans() . '</h5>
                                   <p>' . $comments[$i]->comment . '</p>
                                    <button type="button" class="btn btn-danger delete mt-2 mr-2" data-id="' . $comments[$i]->id . '">Delete</button>
                                    <button type="button" class="btn btn-default reply mt-2" id="reply_' . $i . '" data-id="' . $comments[$i]->id . '">Reply</button>';
            $output .= $this->get_reply_comment($request->blog_id, $comments[$i]->id);
            '</div>
                            </li>';
            $output .= '</ul>
                        </div>
                    </div>';
        }
        return response()->json(['status' => true, 'data' => $output]);
    }
    public function get_reply_comment($blog_id, $comment_id)
    {
        $comments = Comment::where('blog_id', $blog_id)->where('parent_id', $comment_id)->get();
        $output = '';
        for ($i = 0; $i < count($comments); $i++) {

            $output .= '<div class="replied-box">
                    <h5> <b>@</b>' .  $comments[$i]->getUser->firstname . '  ' . $comments[$i]->created_at->diffForHumans() . '</h5>
                   
                    <p>' .  $comments[$i]->comment . '</p>
                    <button type="button" class="btn btn-danger delete"  data-id="' .  $comments[$i]->id . '" mt-2 mr-2">Delete</button>
                    <button type="button" class="btn btn-default reply mt-2" id="reply_' . $i . '" data-id="' .  $comments[$i]->id . '">Reply</button>
                    ';

            $output .= $this->get_reply_comment($blog_id, $comments[$i]->id);
            '</div>';
            if ($comments[$i]->parent_id == $comment_id) {
                $output .= '</div>';
            }
        }

        return $output;
    }
}
