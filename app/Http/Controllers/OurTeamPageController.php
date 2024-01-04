<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class OurTeamPageController extends Controller
{
    public function index() {
        $property_types = Category::select('name')->get();
        return view('our-team',compact('property_types'));
    }
}
