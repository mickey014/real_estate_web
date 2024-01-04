<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Paginator\Paginator;

class BuyPageController extends Controller
{
    public function index() {
        $per_page = 5;
        $data = [];
        $property = Property::query()
                    ->orderBy('is_sold', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->where('property_status', 'buy')
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
        $rent_property_sidebar = Property::orderBy('created_at', 'desc')
                        ->where('property_status', 'rent')
                        ->limit(5)
                        ->get();
        $property_types = Category::select('name')->get();
        return view('buy-property/buy', compact('property', 'featured_prop', 'rent_property_sidebar', 'property_types'));
    }

    public function buySingleProperty(string $buy_single_slug) {
        $single_property = Property::query()
                            ->where('property_status', 'buy')
                            ->where('property_name_slug', $buy_single_slug)
                            ->first();
        $property_types = Category::select('name')->get();
        if($single_property) {
            return view('buy-property/buy-single-property',compact('single_property', 'property_types'));
        } else {    
            return abort(404);
        }
    }

   

    
}
