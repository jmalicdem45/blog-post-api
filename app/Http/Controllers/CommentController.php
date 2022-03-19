<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
   public function getAll() {
       $result = Comment::with('children')->where('parent_id', null)->orderBy('id', 'DESC')->get();
       return new Response($result, 200);
   }

   public function create(Request $request) {

       $request->validate([
           'name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
           'comment' => 'required',
           'level' => 'numeric',
           'parent_id' => 'numeric|nullable'
       ]);

       $input = $request->all();
       $level = $this->getLevel($input['parent_id']);

       if ($level > 3) {
        return new Response('Comments are up to 3 layers only', 422);
       }

       $input['level'] = $level;

       $comments = Comment::create($input);

       return new Response($comments, 201);
   }

   private function getLevel($parentId) {
       if ($parentId) {
        $comment = Comment::find($parentId);
        if ($comment) {
            return ($comment->level + 1);
        }
        return 1;
       }
       return 1;
   }
}
