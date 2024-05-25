<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        if (request()->hasAny(['birth_date', 'state', 'bio', 'avatar'])) {
            $attributes = request()->validate([
                'birth_date' => 'sometimes|required|date',
                'state' => 'sometimes|required|string',
                'bio' => 'string',
                'avatar' => 'sometimes|required|image'
            ]);

            if (request()->has('avatar')) {
                $path = Storage::putFile('avatars', $attributes['avatar']);
                unset($attributes['avatar']);

                if ($path) {
                    $attributes['avatar_url'] = $path;
                }
            }

            $request->user()->profile()->update($attributes);
        } else {
            $attributes = request()->validate([
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email',
            ]);
            $request->user()->update($attributes);
        }

        return $request->user()->load('profile');
    }
}
