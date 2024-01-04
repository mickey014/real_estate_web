<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Support\Str;

class SearchPageController extends Controller {
    public function index(Request $request) {
        $data = []; 
        $search_status = $request->get('status');
        $search_type = $request->get('type');
        $search_location = $request->get('location');
        $per_page = 5;

        if( isset($search_status) && isset($search_type) && !isset($search_location) )  {
            
            
            $search_by_status_and_type = '';

            if($search_type == 'all') {
                $search_by_status_and_type =  Property::query()
                ->orderBy('is_sold', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->where('property_status', 'LIKE', '%' .$search_status .'%')
                ->paginate($per_page);
            } else {
                $search_by_status_and_type =  Property::query()
                ->orderBy('is_sold', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->where('property_status', 'LIKE', '%' .$search_status .'%')
                ->where('property_type', 'LIKE', '%' .$search_type. '%')
                ->paginate($per_page);
            }

            
            $last_page = $search_by_status_and_type->lastPage();
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
            $rent_property_sidebar = Property::orderBy('created_at', 'desc')
            ->where('property_status', 'rent')
            ->limit(5)
            ->get();
            $buy_property_sidebar = Property::orderBy('created_at', 'desc')
            ->where('property_status', 'buy')
            ->limit(5)
            ->get();
            $property_types = Category::select('name')->get();

            return view('search',compact('search_by_status_and_type', 'featured_prop', 'rent_property_sidebar', 'buy_property_sidebar', 'property_types'));
            
        } elseif(isset($search_location) )  {

            if($search_type == 'all') {
                $search_by_status_and_type =  Property::query()
                ->orderBy('is_sold', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->where('property_status', 'LIKE', '%' .$search_status .'%')
                ->where('location.street_address', 'LIKE', '%' .$search_location. '%')
                ->paginate($per_page);
            } else {
                $search_by_status_and_type =  Property::query()
                ->orderBy('is_sold', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->where('property_status', 'LIKE', '%' .$search_status .'%')
                ->where('property_type', 'LIKE', '%' .$search_type. '%')
                ->where('location.street_address', 'LIKE', '%' .$search_location. '%')
                ->paginate($per_page);
            }

            $last_page = $search_by_status_and_type->lastPage();
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
            $rent_property_sidebar = Property::orderBy('created_at', 'desc')
            ->where('property_status', 'rent')
            ->limit(5)
            ->get();
            $buy_property_sidebar = Property::orderBy('created_at', 'desc')
            ->where('property_status', 'buy')
            ->limit(5)
            ->get();
            $property_types = Category::select('name')->get();

            return view('search',compact('search_by_status_and_type', 'featured_prop', 'rent_property_sidebar', 'buy_property_sidebar', 'property_types'));
        } else {
            abort(404);
        }    
       
    }

 

    // public function buySingleProperty(string $buy_single_slug) {
    //     $single_property = Property::where('property_name_slug', $buy_single_slug)->first();
    //     if($single_property) {

    //         return view('buy-property/buy-single-property',compact('single_property'));
    //     } else {    
    //         return abort(404);
    //     }
    // }
}
