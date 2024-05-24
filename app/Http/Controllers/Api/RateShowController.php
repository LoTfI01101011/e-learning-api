<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\rate;
use App\Models\User;

class RateShowController extends Controller
{
    public function __invoke(User $teacher)
    {
        $rate = rate::where('teacher_id', $teacher->id)->avg('rate');

        if ($rate == null) {
            abort(404);
        }

        return response()->json(
            ['rate' => number_format($rate, 1)]
        );
    }
}
