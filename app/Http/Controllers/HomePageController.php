<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Property;

class HomePageController extends Controller
{
    //
    public function index() {
       
        $property_types = Category::select('name')->get();
        $property_listing = Property::orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
        $apartments = Property::select(['property_types', 'property_bed', 'property_bath', 'property_after_price', 'property_gallery.featured_img', 'location.street_address'])
                    ->where('property_type', 'Apartments')
                    ->where('property_status', 'rent')
                    ->orderBy('created_at', 'desc')
                    ->get();
        $users = User::select('id')
                    ->get();
        $agent = Agent::select('id')
                    ->get();
        return view('index', compact('property_types', 'property_listing', 'apartments', 'users', 'agent'));
    }

    public function autocomplete(Request $request) {
        $populate_loc = Property::select(['location.street_address'])
                ->where('location.street_address', 'LIKE', '%' .$request->get('query'). '%')
                ->limit(3)
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique('location.street_address');
        
                foreach ($populate_loc as $loc)
                {
                    $data[] = strtolower($loc->location['street_address']);
                }
        return response()->json($data);
    }

    public function apartmentAutocomplete(Request $request) {
        $populate_loc = Property::select(['location.street_address'])
                ->where('property_type', 'Apartments')
                ->where('property_status', 'rent')
                ->orWhere('location.street_address', 'LIKE', '%' .$request->get('query'). '%')
                ->limit(3)
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique('location.street_address');

                foreach ($populate_loc as $loc)
                {
                    $data[] = strtolower($loc->location['street_address']);
                }
        return response()->json($data);
    }
   

}
