<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\reply;
use Illuminate\Http\Request;

class CourseReplyController extends Controller
{
    public function store(Announcement $announcement, Comment $comment, Request $request)
    {

        $request->validate([
            'reply' =>  ['required', 'string'],
        ]);

        $reply = reply::create([
            'user_id' => auth()->id(),
            'announcement_id' => $announcement->id,
            'comment_id' => $comment->id,
            'reply' => $request->reply
        ]);

        return response()->json($reply, 200);
    }
    public function update(reply $reply, Request $request)
    {
        $attributes = $request->validate([
            'reply' => ['required', 'string']
        ]);

        $result =  $reply->update($attributes);

        return response()->json($result);
    }

    public function destroy(reply $reply)
    {

        $reply->delete();

        return response()->noContent();
    }
}
