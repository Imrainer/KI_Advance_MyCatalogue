<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Categories;
use App\Models\Note;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class MonitoringControllers extends Controller
{   

    public function GetSessionCount() {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $sessionCount = $user->sessions()->count();

        return $sessionCount;
    }

    public function monitoring (request $request)
    {  
       $admin = session('id');
       $admin = Admin::where('id', $admin)->first();
       $userCount = User::count();
       $noteCount = Note::count();
       $categoriesCount = Categories::count();
    //    $sessionCount = $this->GetSessionCount();
       return view('pages/Monitoring', compact('admin','userCount', 'categoriesCount', 'noteCount'));
    }

}
