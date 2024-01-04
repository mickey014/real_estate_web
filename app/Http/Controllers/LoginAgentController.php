<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginAgentController extends Controller
{
    //
    public function index() {
        $data = [];

        
        if(Session::has('loggedinUser')) {
            $data = ['user_info' => User::where('_id', '=', session('loggedinUser'))->first()];
            return redirect('/listings');
        }
        return view('agent/login',$data);
    }
}
