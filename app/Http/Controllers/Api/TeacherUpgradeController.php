<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeacherUpgradeController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'title' =>  ['required', 'string'],
            'university' => ['required', 'string'],
            'graduation_date' => ['required', 'date_format:Y-m-d'],
        ]);

        $attributes = $request->user();

        if ( $attributes['category'] == 1) {
            throw ValidationException::withMessages([
                'category' => ['The provided User is actually a Teacher.'],
            ]);
        }

        $request->user()->update([
            'category' => 'teacher'
        ]);

        $certficate = Certificate::create([
            'user_id' => auth()->id(),
            'title' =>  $request->title,
            'university' => $request->university,
            'graduation_date' => $request->graduation_date,
        ]);

        return response()->json($certficate,200);
    }
}
