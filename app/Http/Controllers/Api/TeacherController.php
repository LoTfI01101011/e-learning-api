<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    public function show(User $teacher){

    if(!$teacher->categroy == 'teacher'){
        abort(401, 'Unauthorized: This user is not a teacher.');
    }
    
    $teacher->load('profile');

    
    $profile = $teacher->profile;

    
    if ($profile && $profile->avatar_url) {
        $profile->full_avatar_url = Storage::url($profile->avatar_url);
    }

    return response()->json($teacher);
    }
    
}
