<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Paginator\Paginator;

class RentPageController extends Controller
{
    public function index() {
        $per_page = 5;
        $data = [];
        $property = Property::query()
                    ->orderBy('is_sold', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->where('property_status', 'rent')
                    ->paginate($per_page);
        $last_page = $property->lastPage();

        if(isset($_GET['page'])) {
            $page = $_GET['page'];
            if($page>$last_page) {
                abort(404);
            }
        }

        $featured_prop = Property::orderBy('created_at', 'desc')
                        ->where('is_featured', 1)
                        ->limit(5)
                        ->get();
        $buy_property_sidebar = Property::orderBy('created_at', 'desc')
                        ->where('property_status', 'buy')
                        ->limit(5)
                        ->get();
        $property_types = Category::select('name')->get();
        return view('rent-property/rent', compact('property', 'featured_prop', 'buy_property_sidebar', 'property_types'));
    }

    public function rentSingleProperty(string $rent_single_slug) {
        $single_property = Property::query()
                        ->where('property_status', 'rent')
                        ->where('property_name_slug', $rent_single_slug)
                        ->first();
        $property_types = Category::select('name')->get();
        if($single_property) {

            return view('rent-property/rent-single-property',compact('single_property', 'property_types'));
        } else {    
            return abort(404);
        }
    }
}
