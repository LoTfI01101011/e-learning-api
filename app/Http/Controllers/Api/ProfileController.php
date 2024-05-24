<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'birth_date' =>  ['required', 'date_format:Y-m-d'],
            'avatar' => ['required', 'image'],
            'state' => ['string', 'required'],
            'bio' => ['string', 'sometimes'],
        ]);
        Profile::create([
            'user_id' => auth()->id(),
            'birth_date' =>  $request->birth_date,
            'avatar_url' => $request->file('avatar')->store('avatars'),
            'state' => $request->state,
            'bio' => $request->bio,
        ]);

        //php artisan storage:link
        $user = $request->user()->load('profile');

        // Retrieve the avatar path and generate the full URL
        $avatarPath = $user->profile->avatar_url;
        $fullAvatarUrl = Storage::url($avatarPath);

        if (strpos($avatarPath, 'storage/') === 0) {
            $fullAvatarUrl = env('APP_URL') . '/' . $avatarPath; // Use APP_URL to generate the correct URL
        }

        return response()->json(['user' => $request->user()->load('profile'), 'full_avatar_url' => $fullAvatarUrl]);
    }

    public function show(Request $request)
    {
        $user = $request->user()->load('profile');

        // Retrieve the avatar path and generate the full URL
        $avatarPath = $user->profile->avatar_url;
        $fullAvatarUrl = Storage::url($avatarPath);

        if (strpos($avatarPath, 'storage/') === 0) {
            $fullAvatarUrl = env('APP_URL') . '/' . $avatarPath; // Use APP_URL to generate the correct URL
        }

        return response()->json(['user' => $request->user()->load('profile'), 'full_avatar_url' => $fullAvatarUrl]);
    }




    public function update(Request $request)
    {

        if ($request->name || $request->email) {
            $attributes = $request->validate([
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email'
            ]);
            $request->user()->update($attributes);
        }
        if ($request->hasFile('avatar_url')) {
            $request->validate([
                'avatar_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        
            $avatarPath = $request->file('avatar_url')->store('avatars');
               dd($avatarPath) ;
            $request->user()->profile()->update([
                'avatar_url' => $avatarPath
            ]);
            abort(200);
        }


        $attributes = $request->validate([
            'birth_date' => 'sometimes|required|date_format:Y-m-d',
            'state' => 'sometimes|required|string',
            'bio' => 'string',

        ]);

        return response()->json($request->user()->profile()->update($attributes));
    }
}
