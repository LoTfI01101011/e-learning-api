<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use function PHPSTORM_META\type;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'title' =>  ['required', 'string'],
            'description' => ['required', 'string'],
            'field' => ['required', 'string'],
            'module' => ['required', 'string'],
            'type' =>  ['required', 'string'],
            'location' => ['sometimes'],
            'price' => ['required', 'string'],
            'status' => ['required', 'string'],
            'student_count' => ['required', 'numeric'],
        ]);


        if (!in_array($request->type, ['offline', 'online']) || !in_array($request->status, ['closed', 'opened']) || !in_array($request->field, ['computer science', 'mathematics', 'english', 'other'])) {
            return response()->json(['error' => 'Resource not found'], 404);
        }


        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'title' =>  $request->title,
            'description' =>  $request->description,
            'field' => $request->field,
            'module' => $request->module,
            'type' =>  $request->type,
            'location' =>  $request->location,
            'price' =>  $request->price,
            'status' =>  $request->status,
            'student_count' =>  $request->student_count,
        ]);

        //php artisan storage:link

        return response()->json($announcement, 200);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $attributes = $request->validate([
            'title' =>  ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'field' => ['sometimes', 'string'],
            'module' => ['sometimes', 'string'],
            'type' =>  ['sometimes', 'numeric'],
            'location' => ['sometimes', 'string'],
            'price' => ['sometimes', 'string'],
            'status' => ['sometimes', 'numeric'],
            'student_count' => ['sometimes', 'numeric'],
        ]);

        if ($request->field && !in_array($request->field, ['computer science', 'mathematics', 'english', 'other'])) {

            abort(404);
        }

        $announcement->update($attributes);

        return response()->json($announcement, 200);
    }

    public function destroy(Announcement $announcement)
    {
        $resource = Announcement::find($announcement->id);

        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $resource->delete();

        return response()->noContent();
    }

    public function show(Announcement $announcement)
    {
        $resource = Announcement::find($announcement->id);
        if (!$resource) {
            return response()->json(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }


        $announcement->loadCount('like');

        $announcement->load('comment.reply');

        $announcement->load('user.profile');
        return response()->json($announcement);
    }
}
