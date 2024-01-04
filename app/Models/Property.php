<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Carbon;

class Property extends Eloquent
{
    use HasFactory;
    protected $collection = 'property';
    protected $fillable = [
        'property_type',
        'property_status',
        'property_name',
        'property_desc',
        'property_floors',
        'floor_plan1',
        'floor_plan2',
        'floor_plan3',
        'floor_plans_img',
        'property_bed',
        'property_bath',
        'property_rooms',
        'property_garages',
        'property_area',
        'property_size',
        'property_before_price',
        'property_after_price',
        'property_year_built',
        'aircon',
        'emergency_exit',
        'fully_furnished',
        'semi_furnished',
        'gym',
        'kitchen',
        'laundry',
        'lawn',
        'onsite_parking',
        'shared_internet',
        'featured_img',
        'gallery_img1',
        'gallery_img2',
        'gallery_img3',
        'gallery_img4',
        'street_address',   
        'province',
        'barangay',
        'city_municipality',
        'postal_code',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
