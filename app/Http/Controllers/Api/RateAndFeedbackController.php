<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Profile;
use App\Models\rate;
use App\Models\User;
use Illuminate\Http\Request;

class RateAndFeedbackController extends Controller
{
    public function store(User $teacher, Request $request)
    {
        $request->validate([
            'rate' =>  ['required', 'numeric'],
            'feedback' => ['required', 'string']
        ]);

        $user = User::where('id', $teacher->id)->first();

        if ($user->category === 'student') {
            return abort(404);
        }

        $rate = rate::create([
            'user_id' => auth()->id(),
            'teacher_id' => $teacher->id,
            'rate' => $request->rate,
            'feedback' => $request->feedback
        ]);

        return response()->json($rate, 200);
    }
    public function update(rate $rate, Request $request)
    {
        $attributes =  $request->validate([
            'rate' => ['sometimes', 'numeric'],
            'feedback' => ['sometimes', 'string']
        ]);
        
        $id = $rate->user_id;

        if ($id != auth()->id()) {
            return abort(401);
        }
        $rate->update($attributes);

        $rate->refresh();

        return response()->json($rate,200);
    }
    public function show()
    {
        return response()->json(rate::all()->load('user.profile'));
    }
    public function destroy(rate $rate)
    {

        $rate->delete();

        return response()->noContent();
    }
}
