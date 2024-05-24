<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;

class CourseCommentController extends Controller
{
    public function store(Announcement $announcement, Request $request)
    {

        $request->validate([
            'comment' =>  ['required', 'string'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'announcement_id' => $announcement->id,
            'comment' => $request->comment
        ]);

        return response()->json($comment, 200);
    }
    public function update(Comment $comment , Request $request) {
        $attributes = $request->validate([
            'comment' => ['required' , 'string']
        ]);
        
        $result =  $comment->update($attributes);

        return response()->json($result);
    }

    public function destroy(Comment $comment) {
        
        $comment->delete();

        return response()->noContent();
    }
}
