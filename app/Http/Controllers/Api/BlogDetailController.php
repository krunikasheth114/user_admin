<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Blog;
use Illuminate\Support\Facades\URL;
use App\Models\View;
use App\Models\Comment;
use App\Models\Like;

use Illuminate\Support\Facades\Auth;

class BlogDetailController extends BaseController
{
    public function index(Request $request, $slug)
    {
        $view = Blog::where('slug', $slug)->first();

        if (!empty($view)) {
            $url    = URL::current();
            $visit = View::create(['blog_id' => $view->id, 'ip' => $request->ip(), 'url' => $url]);
            $comments = Comment::where('blog_id', $view->id)
                ->where('parent_id', '=', 0)->get();
            $data = [$view, $url, $visit, $comments];
            return $this->sendResponse($data, 'data-details');
        } else {
            return $this->sendError($view, 'data not found');
        }
    }
    public function like(Request $request, $id)
    {

        $like = Like::where('blog_id', $id)->where('user_id', \Auth::user()->id)->first();

        if (empty($like)) {
            $like = Like::create(['blog_id' => $id, 'user_id' => \Auth::user()->id]);
            return $this->sendResponse($like, 'likes created');
        } else {
            $like->delete();
            return $this->sendResponse($like, 'likes deleted');
        }
    }
    public function comment(Request $request)
    {
        $request->validate([
            'blog_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);
        $comment = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment]);
        if ($comment) {
            return $this->sendResponse($comment, 'Comment created');
        } else {
            return $this->sendError($comment, 'Something Went Wrong');
        }
    }
    public function delete($id)
    {
        $delete = Comment::find($id);
        if (!empty($delete)) {
            $delete->delete();
            return $this->sendResponse($delete, 'Comment deleted');
        } else {
            return $this->sendError($delete, 'ID not Found');
        }
    }
    public function commentReply(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'comment_reply' => 'required',
            'parent_id' => 'required|numeric',
        ]);
        $commentRep = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment_reply, 'parent_id' => $request->parent_id]);
        if (!empty($commentRep)) {
            return $this->sendResponse($commentRep, 'replyed');
        } else {
            return $this->sendError($commentRep, 'Enter valid Data');
        }
    }
    public function response(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'comment' => 'required',
            'parent_id' => 'required|numeric',
        ]);
        $commentRes = Comment::create(['blog_id' => $request->blog_id, 'user_id' => \Auth::user()->id, 'comment' => $request->comment, 'parent_id' => $request->parent_id]);
        if (isset($commentRes)) {
            return $this->sendResponse($commentRes, 'replyed');
        } else {
            return $this->sendError($commentRes, 'Enter valid Data');
        }
    }
    public function fetchComment($id)
    {
        $comments = Comment::where('blog_id', $id)->where('parent_id', 0)->get();
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
            $output .= $this->get_reply_comment($id, $comments[$i]->id);
            '</div>
                                    </li>';
            $output .= '</ul>
                                </div>
                            </div>';
        }
        return $this->sendResponse($comments, 'comments fetch');
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
