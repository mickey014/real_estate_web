<?php
// dd(auth()->user()->username);
$users = '';
if(auth()->user()->username != null) {
    $users = auth()->user()->username;
} else {
    $users = 'users';
}

$disable_new_property_btn = (auth()->user()->username == null && auth()->user()->contact_no == null && auth()->user()->response_time == null && auth()->user()->response_rate == null && auth()->user()->address == null && auth()->user()) ? 'disabled' : '' ;

$cursor_not_allowed = (auth()->user()->username == null && auth()->user()->contact_no == null && auth()->user()->response_time == null && auth()->user()->response_rate == null && auth()->user()->address == null && auth()->user()) ? 'not-allowed' : '' ;

?>
@section('title', $users)
@extends('layouts.app')


  @section('content')
    
    <header id="home" class="home">
        <x-navbar />
    </header>

    <div style="margin-top: 4.4rem;"></div>

    @if(auth()->user()->email_verified_at == null)
    <div class="alert alert-warning alert-dismissible fade show activate-email-wrapper" role="alert" id="alert-missing-fields">
        <h4 class="alert-heading">Activate your email first.</h4>
        
        @if(auth()->user()->email_verified_at == null)
        <p class="activate-email mb-0">
            You must activate your email in order to list a property.
            <input type="hidden" class="activate_email_input" name="activate_email_input" value="{{ auth()->user()->email }}">
                <input type="submit" value="Click here" class="btn activate_email_btn" name="activate_email_btn">
        </p>
        @endif
        

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        
    </div>
    @endif

    @if(auth()->user()->username == null && auth()->user()->contact_no == null && auth()->user()->response_time == null && auth()->user()->response_rate == null)
    <div class="alert alert-warning alert-dismissible fade show mt-0" role="alert" id="alert-missing-fields">
        <h4 class="alert-heading">Missing Fields!</h4>
        <p class="mb-0">You must complete your personal information @if(auth()->user()->email_verified_at == null)and activate your email @endif in order to list a property.</p>
        

        <ul>
            <li>> Username</li>
            <li>> Contact #</li>
            <li>> Response time</li>
            <li>> Response rate</li>
            <li>> Address</li>
        </ul>

        

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        
    </div>
    @endif
    
    

    <section id="user-account">
        <div class="user-account-wrapper">
            <div class="rounded-lg d-block d-sm-flex">
                <div class="profile-tab-nav border-right">
                    <div class="avatar">
                        <div class="img-circle text-center mb-3">
                            
                            @if(auth()->user()->images != null)
                            <img src="{{ URL('uploads/profile_pic'). '/' . auth()->user()->images }}" 
                            alt="Image" class="shadow" id="change_profile_pic_preview">
                            @else
                            <img src="{{ URL('uploads/profile_pic/businessman.png') }}" 
                            alt="Image" class="shadow" id="change_profile_pic_preview">
                            @endif
                        </div>
                        <input type="file" name="change_profile_pic" id="change_profile_pic" class="form-control">
                        <input type="hidden" name="change_profile_user_id" id="change_profile_user_id" 
                        value="{{ auth()->user()->_id }}">
                        
                        <h4 class="text-center py-2 pb-1" style="font-size:1.6rem;">{{ auth()->user()->name  }}</h4>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="user-tab" data-toggle="pill" href="#user-dashboard" role="tab" aria-controls="user-dashboard" aria-selected="true">
                            <i class="fa-solid fa-chart-pie mr-1"></i>
                            Dashboard
                        </a>
                        {{-- <a class="nav-link" id="user-favourites-tab" data-toggle="pill" href="#user-favourites" role="tab" aria-controls="user-favourites" aria-selected="true">
                            <i class="fa-solid fa-heart mr-1"></i>
                            Favourites
                        </a> --}}
                        <a class="nav-link" id="user-property-tab" data-toggle="pill" href="#user-property" role="tab" aria-controls="user-property" aria-selected="false">
                            <i class="fa-solid fa-hand-holding-dollar mr-1"></i>
                            Properties
                        </a>

                        {{-- <a class="nav-link" id="user-archived-property-tab" data-toggle="pill" href="#user-archived-property" role="tab" aria-controls="user-archived-property" aria-selected="false">
                            <i class="fa-solid fa-boxes-packing mr-1"></i>
                            Archived Properies
                        </a> --}}

                        <a class="nav-link" id="user-password-tab" data-toggle="pill" href="#user-password" role="tab" aria-controls="user-password" aria-selected="false">
                            <i class="fa-solid fa-key mr-1"></i>
                            Password
                        </a>
                        <a class="nav-link" id="user-settings-tab" data-toggle="pill" href="#user-settings" role="tab" aria-controls="user-settings" aria-selected="false">
                            <i class="fa-solid fa-gear mr-1"></i> 
                            Settings
                        </a>
                    </div>
                </div>
                
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="user-dashboard" role="tabpanel" aria-labelledby="user-tab">
                        <h3 class="mb-4">Account Dashboard</h3>
                       
                        <div class="sell-property">
                            <h5>Looking To Sell Property?</h5>  
                            <p>Post a property on the platform in a simple way.</p>
                            <button data-toggle="modal" data-target="#add-new-property" class="
                            <?= (auth()->user()->email_verified_at == null) ? 'not-allowed' : $cursor_not_allowed ?>" <?= (auth()->user()->email_verified_at == null) ? 'disabled' : $disable_new_property_btn ?> >Post a property </button>
                        </div>
                        <hr>
                        <div class="main-dashboard">
                            <div class="property">
                                <img src="{{ URL('storage/property.png') }}" alt="">
                                <h4>Property</h4>
                                <p id="user-property-listed"></p>
                            </div>

                        </div>
                        


                    </div>

                    <div class="tab-pane fade" id="user-property" role="tabpanel" aria-labelledby="user-property-tab">

                        <div class="user-new-property-wrapper">
                            <h3>Properties Listed</h3>
                            <button type="button" class="btn btn-main new-property {{ $cursor_not_allowed }}" data-toggle="modal" data-target="#add-new-property" {{ $disable_new_property_btn }}>
                                <i class="fa-solid fa-plus"></i>
                                New Property
                            </button>
                        </div>

                        <h5>Manage Properties</h5>
                        <p>Update your listings regularly to get high quality leads.</p>
                        <hr>
                        

                        <div class="user-listed-property-wrapper">

                            @forelse($user_total_listed as $list)   
                            <div class="user-listed-property">
                                <div class="user-listed-property-img">
                                <a href="{{ URL('uploads/new_property'). '/' .$list->property_gallery['featured_img'] }}" class="cwa-lightbox-image" data-desc="{{ $list->property_name }}">
                                        <img src="{{ URL('uploads/new_property'). '/' .$list->property_gallery['featured_img'] }}" alt="">
                                    </a>
                                    
                                   
                                    
                                </div>
                                <div class="user-listed-property-info">
                                    <h5>{{ Str::limit($list->property_name, 30, '...') }}</h5>
                                    <p>
                                        <i class="uil uil-map-marker-alt"></i> 
                                        
                                        {{ Str::limit($list->location['street_address'], 20, '...') }}
                                        
                                        <ul>
                                            <li>
                                            <a href="javascript:" class="dropdown-toggle options" id="property-options-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-user-property-id="{{ $list->_id }}" >
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                                <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="options-dropdown">
                                                <a class="dropdown-item px-3 is_sold_property" href="javascript:" id="is_sold_property">
                                                    <i class="uil uil-dollar-sign-alt"></i>Sold
                                                </a>
                                                <a class="dropdown-item px-3" href="javascript:" data-toggle="modal" data-target="#edit-property">
                                                    <i class="uil uil-edit"></i>
                                                Edit</a>
                                                <a class="dropdown-item px-3 user_delete_property" href="javascript:" id="user_delete_property">
                                                    <i class="uil uil-trash-alt"></i>Delete</a>
                                                </div>
                                            </li>   
                                        </ul>
                                        
                                    </p>
                                    
                                </div>
                            </div>
                            @empty
                            <h4>You have'nt had Listed, or your property is sold.</h4>
                            @endforelse
                            
                        </div>
                        
                    </div>

                    <div class="tab-pane fade" id="user-password" role="tabpanel" aria-labelledby="user-password-tab">
                        <div id="user-password-validation" role="alert"></div>
                        <h3 class="mb-4">Account Settings</h3>
                        <h5>Change Password</h5>
                        <p>Double check your password before change it.</p>
                        <hr>
                        <form action="{{ route('account.chngUserPass') }}" method="POST" id="chng_user_pass_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Old password</label>
                                        <input type="password" class="form-control" name="user_old_password" id="user_old_password">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input type="password" class="form-control" name="user_new_password" id="user_new_password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm password</label>
                                        <input type="password" class="form-control" name="user_confirm_password" id="user_confirm_password">
                                    </div>
                                </div>
                            </div>
                                
                            
                            <div>
                                <button type="submit" class="btn btn-main" id="user-change-pass-btn">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="user-settings" role="tabpanel" aria-labelledby="user-settings-tab">
                        <div id="user-info-validation" role="alert"></div>
                        <h3 class="mb-4">Account Settings</h3>
                        <h5>Personal Information</h5>
                        <hr>
                        <form method="POST" id="user_settings_form" action="{{ route('account.chngUserInfo') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->username }}" name="username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->email }}" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact #</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->contact_no }}" name="contact_no" id="contact_no">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Response time:</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->response_time }}" name="response_time" id="response_time">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Response rate:</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->response_rate }}" name="response_rate" id="response_rate">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" rows="4" name="address">{{ auth()->user()->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-main">Submit</button>
                        </div>
                        
                            
                        </form>
                    </div>

                </div>
            </div>
        </div>

         <!-- Add New Property Modal -->
         <div class="modal fade pr-0" id="add-new-property" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
           

            <div id="new-property-validation" role="alert"></div>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h3 class="modal-title" id="staticBackdropLabel"><i class="uil uil-estate mr-1"></i>New Property</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                <form method="POST" action="{{ route('account.addNewProperty') }}" enctype="multipart/form-data" id="add-new-property-form" >
                    @csrf
                    {{-- <input type="hidden" name="user_id" id="user_id" value="@isset($user_info){{ $user_info->_id; }}@endisset"> --}}
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->_id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="property-type">Property Type:</label>
                                    <select name="property_type" id="property_type" class="form-control">
                                        
                                        @forelse($property_types as $type)
                                        <option value="{{ $type['name'] }}">{{ $type['name'] }}</option>
                                        @empty
                                        @endforelse
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="property_status">Status:</label>
                                    <select name="property_status" id="property_status" class="form-control">
                                        <option value="buy">Buy</option>
                                        <option value="rent">Rent</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') == 1 ? 'checked' : "" }}>
                                    <label for="is_featured">is featured?</label>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="property_before_price">
                                        Before Price: 
                                        <small class="text-danger before-price-label">(*Value)</small>
                                    </label>
                                    <input type="text" class="form-control property_before_price" id="property_before_price" name="property_before_price">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label for="property_after_price">
                                        After Price: 
                                        <small class="text-danger after-price-label">(*Value)</small>
                                    </label>
                                    <input type="text" class="form-control property_after_price" id="property_after_price" name="property_after_price">
                                    <span class="text-danger error-text property_after_price_error"></span>
                                </div>
                            </div>

                            <hr>
                            

                            <div class="form-group">
                                <label for="property_name">Property Name:</label>
                                <input type="text" class="form-control" id="property_name" name="property_name">
                                <span class="text-danger error-text property_name_error"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="property_desc">Description:</label>
                                <textarea class="form-control" id="property_desc" name="property_desc" rows="5"></textarea>
                                <span class="text-danger error-text property_desc_error"></span>
                            </div>

                            <hr>
                            <p class="text-danger mb-0">(Optional)</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="property_floors">Floors</label>
                                    <input type="number" class="form-control property_floors" id="property_floors" name="property_floors" value="0" min="0" max="3">
                                </div>
                                <div class="col-md-6">
                                    <label for="floor_plan1">Floor Plan1</label>
                                    <input type="file" name="floor_plan1" id="floor_plan1" class="form-control">
                                    <span class="text-danger error-text floor_plans_img_error"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="floor_plan2">Floor Plan2</label>
                                    <input type="file" name="floor_plan2" id="floor_plan2" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="floor_plan3">Floor Plan3</label>
                                    <input type="file" name="floor_plan3" id="floor_plan3" class="form-control">
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="property_bed">Bedrooms</label>
                                    <input type="number" class="form-control" id="property_bed" name="property_bed" min="1" max="10" value="1">
                                    
                                </div>
                                <div class="col-md-4">
                                    <label for="property_bath">Bathrooms</label>
                                    <input type="number" class="form-control" id="property_bath" name="property_bath" value="1" min="1" max="10">
                                </div>
                                <div class="col-md-4">
                                    <label for="property_rooms">Rooms</label>
                                    <input type="number" class="form-control" id="property_rooms" name="property_rooms" value="1" min="1" max="10">
                                </div>
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="property_garages">Garages</label>
                                    <input type="number" class="form-control" id="property_garages" name="property_garages" min="0" max="10" value="0">
                                </div>
                                <div class="col-md-3">
                                    <label for="property_area">Area</label>
                                    <input type="text" class="form-control" id="property_area" name="property_area" placeholder="sq ft">
                                    
                                </div>
                                <div class="col-md-3">
                                    <label for="property_size">Size</label>
                                    <input type="text" class="form-control" id="property_size" name="property_size" placeholder="sq ft">
                                    
                                </div>
                                <div class="col-md-3">
                                    <label for="property_year_built">Year Built</label>
                                    <input type="date" class="form-control" id="property_year_built" name="property_year_built">
                                </div>
                            </div>

                            

                            <hr>
                            <h3>Amenities</h3>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input type="checkbox" name="aircon" id="aircon" value="1" {{ old('aircon') == 1 ? 'checked' : "" }}>
                                    <label for="aircon">Air conditioning</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="emergency_exit" id="emergency_exit" value="1" {{ old('emergency_exit') == 1 ? 'checked' : "" }}>
                                    <label for="emergency_exit"">Emergency Exit</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="fully_furnished" id="fully_furnished" value="1" {{ old('fully_furnished') == 1 ? 'checked' : "" }}>
                                    <label for="fully_furnished">Fully Furnished</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="semi_furnished" id="semi_furnished" value="1" {{ old('semi_furnished') == 1 ? 'checked' : "" }}>
                                    <label for="semi_furnished">Semi Furnished</label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input type="checkbox" name="gym" id="gym" value="1" {{ old('gym') == 1 ? 'checked' : "" }}>
                                    <label for="gym">Gym</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="kitchen" id="kitchen" value="1" {{ old('kitchen') == 1 ? 'checked' : "" }}>
                                    <label for="kitchen">Kitchen</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="laundry" id="laundry" value="1" {{ old('laundry') == 1 ? 'checked' : "" }}>
                                    <label for="laundry">Laundry Room</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="lawn" id="lawn" value="1" {{ old('lawn') == 1 ? 'checked' : "" }}>
                                    <label for="lawn">Lawn</label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input type="checkbox" name="meeting_rooms" id="meeting_rooms" value="1" {{ old('meeting_rooms') == 1 ? 'checked' : "" }}>
                                    <label for="meeting_rooms">Meeting Rooms</label>
                                </div>
                               <div class="col-md-3">
                                    <input type="checkbox" name="onsite_parking" id="onsite_parking" value="1" {{ old('onsite_parking') == 1 ? 'checked' : "" }}>
                                    <label for="onsite_parking">On Site Parking</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="shared_internet" id="shared_internet" value="1" {{ old('shared_internet') == 1 ? 'checked' : "" }}>
                                    <label for="shared_internet">Shared Internet</label>
                                </div>
                            </div>

                            <hr>
                            <h3>Gallery</h3>
                            <div class="row mt-3 justify-content-center">
                                <div class="col-md-8">
                                    <label for="featured_img">Featured Image</label>
                                    <input type="file" name="featured_img" id="featured_img" class="form-control">
                                    <span class="text-danger error-text featured_img_error"></span>
                                </div>
                                
                            </div>

                            <div class="row mt-3 justify-content-center">

                                <div class="col-md-3">
                                    <label for="gallery_img1">Gallery Image1</label>
                                    <input type="file" name="gallery_img1" id="gallery_img1" class="form-control">
                                    
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img2">Gallery Image2</label>
                                    <input type="file" name="gallery_img2" id="gallery_img2" class="form-control">
                                    
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img3">Gallery Image3</label>
                                    <input type="file" name="gallery_img3" id="gallery_img3" class="form-control">
                                    
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img4">Gallery Image4</label>
                                    <input type="file" name="gallery_img4" id="gallery_img4" class="form-control">
                                    
                                </div>
                                
                            </div>


                            <hr>
                            <h3>Location</h3>

                            <div class="row mt-3">                                 

                                <div class="col-md-6">
                                    <label for="provinces">Provinces:</label>
                                    <select name="provinces" class="provinces form-control" id="provinces"></select> 
                                </div>
                                <div class="col-md-6">
                                    <label for="cities">Cities:</label>
                                    <select name="cities" class="cities form-control" id="cities"></select> 
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="barangays">Barangay:</label>
                                    <select name="barangays" class="barangays form-control" id="barangays"></select> 
                                </div>

                                <div class="col-md-6">
                                    <label for="postal_code">Postal Code:</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control">
                                </div>

                            </div>

                            <div class="row mt-3 justify-content-center">
                                <div class="col-md-8">
                                    <label for="street_address">Street Address:</label>
                                    <input type="text" name="street_address" id="street_address" class="form-control">
                                </div>
                            </div>


                        
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Edit Property Modal -->
        <div class="modal fade pr-0" id="edit-property" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
           

            <div id="edit-property-validation" role="alert"></div>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <h3 class="modal-title" id="staticBackdropLabel"><i class="uil uil-estate mr-1"></i>Edit Property</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                <form method="POST" action="{{ route('account.updateProperty') }}" enctype="multipart/form-data" id="update-property-form" >
                    @csrf
                    
                    <input type="hidden" name="user_property_info_id" id="user_property_info_id">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->_id }}">
                   
                            <div class="row">
                                <div class="col-md-8" id="property_parent">
                                    <label for="property-type" id="property-type-label">Property Type:</label>
                                    {{-- <select name="property_type" id="property_type" class="form-control"> --}}
                                        
                                    @forelse($property_types as $type)
                                        <button type="button" class="property-type-btn">{{ $type['name'] }}</button>
                                    @empty
                                    @endforelse
                                        
                                    {{-- </select> --}}
                                </div>
                                <div class="col-md-4">
                                    <label for="property_status">Status:</label>
                                    <select name="property_status" id="property_status" class="form-control">
                                        <option value="buy">Buy</option>
                                        <option value="rent">Rent</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') == 1 ? 'checked' : "" }}>
                                    <label for="is_featured">is featured?</label>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="property_before_price">
                                        Before Price: 
                                        <small class="text-danger before-price-label">(*Monthly)</small>
                                    </label>
                                    <input type="text" class="form-control property_before_price" id="property_before_price" name="property_before_price">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label for="property_after_price">
                                        After Price: 
                                        <small class="text-danger after-price-label">(*Monthly)</small>
                                    </label>
                                    <input type="text" class="form-control property_after_price" id="property_after_price" name="property_after_price">
                                    
                                </div>
                            </div>

                            <hr>
                            

                            <div class="form-group">
                                <label for="property_name">Property Name:</label>
                                <input type="text" class="form-control" id="property_name" name="property_name">
                                
                            </div>
                            
                            <div class="form-group">
                                <label for="property_desc">Description:</label>
                                <textarea class="form-control" id="property_desc" name="property_desc" rows="5"></textarea>
                                <span class="text-danger error-text property_desc_error"></span>
                            </div>

                            <hr>
                            <p class="text-danger mb-0">(Optional)</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="property_floors">Floors</label>
                                    <input type="number" class="form-control" id="property_floors" name="property_floors" value="0" min="0" max="3">
                                    {{-- <input type="hidden" name="old_floors" id="old_floors"> --}}
                                </div>
                                <div class="col-md-6">
                                    <label for="floor_plan1">Floor Plan1 
                                        
                                    </label>
                                    <input type="file" name="floor_plan1" id="floor_plan1" class="form-control">
                                    
                                    <input type="hidden" name="old_floor_plan1" id="old_floor_plan1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="floor_plan2">Floor Plan2</label>
                                    <input type="file" name="floor_plan2" id="floor_plan2" class="form-control">
                                    <input type="hidden" name="old_floor_plan2" id="old_floor_plan2">
                                </div>
                                <div class="col-md-6">
                                    <label for="floor_plan3">Floor Plan3</label>
                                    <input type="file" name="floor_plan3" id="floor_plan3" class="form-control">
                                    <input type="hidden" name="old_floor_plan3" id="old_floor_plan3">
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="property_bed">Bedrooms</label>
                                    <input type="number" class="form-control" id="property_bed" name="property_bed" min="1" max="10" value="1">
                                    
                                </div>
                                <div class="col-md-4">
                                    <label for="property_bath">Bathrooms</label>
                                    <input type="number" class="form-control" id="property_bath" name="property_bath" value="1" min="1" max="10">
                                </div>
                                <div class="col-md-4">
                                    <label for="property_rooms">Rooms</label>
                                    <input type="number" class="form-control" id="property_rooms" name="property_rooms" value="1" min="1" max="10">
                                </div>
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="property_garages">Garages</label>
                                    <input type="number" class="form-control" id="property_garages" name="property_garages" min="0" max="10" value="0">
                                </div>
                                <div class="col-md-3">
                                    <label for="property_area">Area</label>
                                    <input type="text" class="form-control" id="property_area" name="property_area" placeholder="sq ft">
                                    
                                </div>
                                <div class="col-md-3">
                                    <label for="property_size">Size</label>
                                    <input type="text" class="form-control" id="property_size" name="property_size" placeholder="sq ft">
                                    
                                </div>
                                <div class="col-md-3">
                                    <label for="property_year_built">Year Built</label>
                                    <input type="date" class="form-control" id="property_year_built" name="property_year_built">
                                </div>
                            </div>

                            

                            <hr>
                            <h3>Amenities</h3>

                            <div class="row mt-3 amenities-check">
                                <div class="col-md-3">
                                    <input type="checkbox" name="aircon" id="aircon" value="1" {{ old('aircon') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="aircon">Air conditioning</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="emergency_exit" id="emergency_exit" value="1" {{ old('emergency_exit') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="emergency_exit"">Emergency Exit</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="fully_furnished" id="fully_furnished" value="1" {{ old('fully_furnished') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="fully_furnished">Fully Furnished</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="semi_furnished" id="semi_furnished" value="1" {{ old('semi_furnished') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="semi_furnished">Semi Furnished</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="gym" id="gym" value="1" {{ old('gym') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="gym">Gym</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="kitchen" id="kitchen" value="1" {{ old('kitchen') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="kitchen">Kitchen</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="laundry" id="laundry" value="1" {{ old('laundry') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="laundry">Laundry Room</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="lawn" id="lawn" value="1" {{ old('lawn') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="lawn">Lawn</label>
                                </div>

                                <div class="col-md-3">
                                    <input type="checkbox" name="meeting_rooms" id="meeting_rooms" value="1" {{ old('meeting_rooms') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="meeting_rooms">Meeting Rooms</label>
                                </div>
                               <div class="col-md-3">
                                    <input type="checkbox" name="onsite_parking" id="onsite_parking" value="1" {{ old('onsite_parking') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="onsite_parking">On Site Parking</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="shared_internet" id="shared_internet" value="1" {{ old('shared_internet') == 1 ? 'checked' : "" }} class="checkbox-amenities">
                                    <label for="shared_internet">Shared Internet</label>
                                </div>
                            </div>

                            

                            <hr>
                            <h3>Gallery</h3>
                            <div class="row mt-3 justify-content-center">
                                <div class="col-md-8">
                                    <label for="featured_img">Featured Image</label>
                                    <input type="file" name="featured_img" id="featured_img" class="form-control">
                                    <input type="hidden" name="old_featured_img" id="old_featured_img">
                                </div>
                                
                            </div>

                            <div class="row mt-3 justify-content-center">

                                <div class="col-md-3">
                                    <label for="gallery_img1">Gallery Image1</label>
                                    <input type="file" name="gallery_img1" id="gallery_img1" class="form-control">
                                    <input type="hidden" name="old_gallery_img1" id="old_gallery_img1">
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img2">Gallery Image2</label>
                                    <input type="file" name="gallery_img2" id="gallery_img2" class="form-control">
                                    <input type="hidden" name="old_gallery_img2" id="old_gallery_img2">
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img3">Gallery Image3</label>
                                    <input type="file" name="gallery_img3" id="gallery_img3" class="form-control">
                                    <input type="hidden" name="old_gallery_img3" id="old_gallery_img3">
                                </div>

                                <div class="col-md-3">
                                    <label for="gallery_img4">Gallery Image4</label>
                                    <input type="file" name="gallery_img4" id="gallery_img4" class="form-control">
                                    <input type="hidden" name="old_gallery_img4" id="old_gallery_img4">
                                </div>
                                
                            </div>


                            <hr>
                            <h3>Location</h3>

                            <div class="row">
                                <a href="javascript:" class="col-md-6" id="show-location-btn">Show Location</a>
                            </div>

                            <div class="row mt-3 d-none" id="show-location-div">                                 

                                <div class="col-md-6">
                                    <label for="provinces">Provinces:</label>
                                    <small id="old_provinces_data" class="bg-info text-white p-1"></small>
                                    <select name="provinces" class="provinces form-control" id="provinces"></select> 
                                </div>
                                <div class="col-md-6">
                                    <label for="cities">Cities:</label>
                                    <small id="old_cities_data" class="bg-info text-white p-1"></small>
                                    <select name="cities" class="cities form-control" id="cities"></select> 
                                </div>

                                <div class="col-md-6">
                                    <label for="barangays">Barangay:</label>
                                    <small id="old_barangays_data" class="bg-info text-white p-1"></small>
                                    <select name="barangays" class="barangays form-control" id="barangays"></select> 
                                </div>

                                <div class="col-md-6">
                                    <label for="postal_code">Postal Code:</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control">
                                </div>

                                <div class="col-md-8 justify-content-center">
                                    <label for="street_address">Street Address:</label>
                                    <input type="text" name="street_address" id="street_address" class="form-control">
                                </div>
                            </div>

                            <div style="height: 80px;" class="heigth-display"></div>
                               
                           


                        
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>


    </section>


        
@endsection

@push('scripts')
<script>
    

    $(document).ready(function() { 

        

        var my_handlers = {
            fill_cities: function(){

                var province_code = $(this).val();
                $('.cities').ph_locations( 'fetch_list', [{"province_code": province_code}]);
            },

            fill_barangays: function(){

                var city_code = $(this).val();
                $('.barangays').ph_locations('fetch_list', [{"city_code": city_code}]);
            }

        };

    UserPropertyTotalListed();
    DisableFutureDate();

    function UserPropertyTotalListed() {
        $.ajax({
            type: "GET",
            url: "{{ route('UserPropertyTotalListed') }}",
            dataType: "json",
            success: function (response) {
                // console.log(response);
                
                $.each(response, function (key, item) {
                    $('#user-property-listed').text(item);
                });
            }
        });
    }

    function DisableFutureDate() {
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear()
        if(month < 10)
        month = '0' + month.toString();
        if(day < 10)
        day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#add-new-property').find('#property_year_built').attr('max', maxDate);
        $('#edit-property').find('#property_year_built').attr('max', maxDate);
    }

    // show rent or sale
    $('#add-new-property').find('#property_status').change(function(){
        var name = $('#add-new-property').find('#property_status').val();
        if(name == 'buy') {
            $('.before-price-label').text('*(Value)')
            $('.after-price-label').text('*(Value)')
        } else if(name == 'rent') {
            $('.before-price-label').text('*(Monthly)')
            $('.after-price-label').text('*(Monthly)')
        }
    }); 
    
    $('#edit-property').find('#property_status').change(function(){
        var name = $('#edit-property').find('#property_status').val();
        if(name == 'buy') {
            $('.before-price-label').text('*(Value)');
            $('.after-price-label').text('*(Value)');
        } else {
            $('.before-price-label').text('*(Monthly)');
            $('.after-price-label').text('*(Monthly)');
        }
    }); 

    $('.options').click(function(e) {
        var id = $(this).attr('data-user-property-id');

        $.ajax
        ({
            url: "{{ route('GetUserPropertyInfo') }}",
            method: 'GET',
            data: { user_property_id: id, _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function (response) {
                
                // console.log(response)
                var _edit = $('#edit-property');
                $('#user_property_info_id').val(id);


                const _prop_type = $('.property-type-btn').each(function (index) {
                    let value = $(this).text();
                    if(response['user_property_info'][0].property_type == value) {
                        $(this).siblings().removeClass('active')
                        $(this).addClass('active');
                        
                    }
                
                });

                

                _edit.find('#property_status').val(response['user_property_info'][0].property_status);
                if(response['user_property_info'][0].property_status == "buy") {
                    $('.before-price-label').text('*(Value)');
                    $('.after-price-label').text('*(Value)');
                } else if(response['user_property_info'][0].property_status == "rent") {
                    $('.before-price-label').text('*(Monthly)');
                    $('.after-price-label').text('*(Monthly)');
                }

                

                if(response['user_property_info'][0].is_featured === 1) {
                    _edit.find('#is_featured').attr('checked', 'checked');
                }

                _edit.find('#property_name').val(response['user_property_info'][0].property_name);
                _edit.find('#property_desc').val(response['user_property_info'][0].property_desc);
                _edit.find('#property_floors').val(response['user_property_info'][0].property_floors);

                // property floors img
                _edit.find('#old_floor_plan1').val(response['user_property_info'][0].property_floor_img.floor_plan1);

                _edit.find('#old_floor_plan2').val(response['user_property_info'][0].property_floor_img.floor_plan2);

                _edit.find('#old_floor_plan3').val(response['user_property_info'][0].property_floor_img.floor_plan3);

                _edit.find('#property_bed').val(response['user_property_info'][0].property_bed);
                _edit.find('#property_bath').val(response['user_property_info'][0].property_bath);
                _edit.find('#property_rooms').val(response['user_property_info'][0].property_rooms);
                _edit.find('#property_garages').val(response['user_property_info'][0].property_garages);
                _edit.find('#property_area').val(response['user_property_info'][0].property_area);
                _edit.find('#property_size').val(response['user_property_info'][0].property_size);
                _edit.find('#property_year_built').val(response['user_property_info'][0].property_year_built);
                _edit.find('#property_before_price').val(response['user_property_info'][0].property_before_price);
                _edit.find('#property_after_price').val(response['user_property_info'][0].property_after_price);
                
                
                
                if(_edit.find('#aircon').val() == response['user_property_info'][0].amenities.aircon) {
                    _edit.find('#aircon').prop('checked', true);
                } else {
                    _edit.find('#aircon').prop('checked', false);
                }

                if(_edit.find('#emergency_exit').val() == response['user_property_info'][0].amenities.emergency_exit) {
                    _edit.find('#emergency_exit').prop('checked', true);
                } else {
                    _edit.find('#emergency_exit').prop('checked', false);
                }

                if(_edit.find('#fully_furnished').val() == response['user_property_info'][0].amenities.fully_furnished) {
                    _edit.find('#fully_furnished').prop('checked', true);
                } else {
                    _edit.find('#fully_furnished').prop('checked', false);
                }

                if(_edit.find('#semi_furnished').val() == response['user_property_info'][0].amenities.semi_furnished) {
                    _edit.find('#semi_furnished').prop('checked', true);
                } else {
                    _edit.find('#semi_furnished').prop('checked', false);
                }

                if(_edit.find('#gym').val() == response['user_property_info'][0].amenities.gym) {
                    _edit.find('#gym').prop('checked', true);
                } else {
                    _edit.find('#gym').prop('checked', false);
                }

                if(_edit.find('#kitchen').val() == response['user_property_info'][0].amenities.kitchen) {
                    _edit.find('#kitchen').prop('checked', true);
                } else {
                    _edit.find('#kitchen').prop('checked', false);
                }

                if(_edit.find('#laundry').val() == response['user_property_info'][0].amenities.laundry) {
                    _edit.find('#laundry').prop('checked', true);
                } else {
                    _edit.find('#laundry').prop('checked', false);
                }

                if(_edit.find('#lawn').val() == response['user_property_info'][0].amenities.lawn) {
                    _edit.find('#lawn').prop('checked', true);
                } else {
                    _edit.find('#lawn').prop('checked', false);
                }

                if(_edit.find('#meeting_rooms').val() == response['user_property_info'][0].amenities.meeting_rooms) {
                    _edit.find('#meeting_rooms').prop('checked', true);
                } else {
                    _edit.find('#meeting_rooms').prop('checked', false);
                }

                if(_edit.find('#onsite_parking').val() == response['user_property_info'][0].amenities.onsite_parking) {
                    _edit.find('#onsite_parking').prop('checked', true);
                } else {
                    _edit.find('#onsite_parking').prop('checked', false);
                }

                if(_edit.find('#shared_internet').val() == response['user_property_info'][0].amenities.shared_internet) {
                    _edit.find('#shared_internet').prop('checked', true);
                } else {
                    _edit.find('#shared_internet').prop('checked', false);
                }

                // old property gallery img
                _edit.find('#old_featured_img').val(response['user_property_info'][0].property_gallery.featured_img);

                _edit.find('#old_gallery_img1').val(response['user_property_info'][0].property_gallery.gallery_img1);

                _edit.find('#old_gallery_img2').val(response['user_property_info'][0].property_gallery.gallery_img2);           

                _edit.find('#old_gallery_img3').val(response['user_property_info'][0].property_gallery.gallery_img3);

                _edit.find('#old_gallery_img4').val(response['user_property_info'][0].property_gallery.gallery_img4);

                _edit.find('#provinces').val('');

                _edit.find('#old_provinces_data').text(response['user_property_info'][0].location.provinces);
                _edit.find('#old_cities_data').text(response['user_property_info'][0].location.cities);
                _edit.find('#old_barangays_data').text(response['user_property_info'][0].location.barangays);
                _edit.find('#postal_code').val(response['user_property_info'][0].location.postal_code)
                _edit.find('#street_address').val(response['user_property_info'][0].location.street_address)
                
                
                
            }
        });
    });

    
    $('#property_parent .property-type-btn').click(function() {
        $(this).siblings().removeClass('active')
        $(this).addClass('active');

        // console.log()
    })

    $('#contact_no').bind('keypress paste',function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            return false;
        }
            
        if($(this).val().length >= 11) {
            return false;
        }
    });

    $('#response_time').bind('keypress paste',function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            return false;
        }
            
        if($(this).val().length >= 2) {
            return false;
        }
    });

    $('#response_rate').bind('keypress paste',function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            return false;
        }
            
        if($(this).val().length >= 2) {
            return false;
        }
    });

    $('.property_after_price, .property_before_price').bind('keypress paste',function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            return false;
        }
    });

    $('.property_floors').bind('keypress paste',function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            return false;
        }
        if($(this).val().length >= 1) {
            return false;
            
        }
        

        
    });

    
    $('.provinces').on('change', my_handlers.fill_cities);
    $('.cities').on('change', my_handlers.fill_barangays);

    $('.provinces').ph_locations({'location_type': 'provinces'});
    $('.cities').ph_locations({'location_type': 'cities'});
    $('.barangays').ph_locations({'location_type': 'barangays'});

    $('.provinces').ph_locations('fetch_list');

    // add new property
    $('#add-new-property-form').submit(function(e) {
        e.preventDefault();
        var form = this;
        var provinces = $('#provinces').find(":selected").text();
        var cities = $('#cities').find(":selected").text();
        var barangays = $('#barangays').find(":selected").text();
        var fd = new FormData(form);

        fd.append('provinces', provinces);
        fd.append('cities', cities);
        fd.append('barangays', barangays);
        
        $.ajax({
          url: $(form).attr('action'),
          method: $(form).attr('method'),
          data: fd,
          processData: false,
          contentType: false,
          dataType: 'json',    
          success: function(response) {
            console.log(response)
            if(response.status == 400) {

                $('#new-property-validation').html("");
                $('#new-property-validation').show();
                $('#new-property-validation').addClass('alert alert-danger fade show')
                $.each(response.errors, function (key, err_value) {
                    //   $(form).find('span.'+key+'_error').text(err_value[0]);
                    $('#new-property-validation').append('<li>*'+err_value+'</li>');
                });   
                $('#new-property-validation').append('<button type="button" class="close" id="remove-validation" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
                  
                  console.log(response);
            } else if(response.status == 200) {
                $(form)[0].reset();
                $('#new-property-validation').hide();
                $('#add-new-property').modal('hide')
                UserPropertyTotalListed();
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: response.success,
                  showConfirmButton: false,
                  timer: 1500
                })
                setInterval(function() {
                  window.location = '/account';
                }, 1500);
            }
          }
      });
    });

    $('#update-property-form').submit(function(e) {
        e.preventDefault();
        var form = this;
        var provinces = $('#provinces').find(":selected").text();
        var cities = $('#cities').find(":selected").text();
        var barangays = $('#barangays').find(":selected").text();
        let fd = new FormData(form);
        
        var property_type = $('.property-type-btn.active').text();
        fd.append('property_type', property_type);
        if(!$('#show-location-div').hasClass("d-none")) {
            
            fd.append('provinces', provinces);
            fd.append('cities', cities);
            fd.append('barangays', barangays);
            
            
        } else {
            fd.append('provinces', $('#old_provinces_data').text());
            fd.append('cities', $('#old_cities_data').text());
            fd.append('barangays', $('#old_barangays_data').text());
        }

        $.ajax({
          url: $(form).attr('action'),
          method: $(form).attr('method'),
          data: fd,
          processData: false,
          contentType: false,
          success: function(response) {
            if(response.status == 400) {

                $('#edit-property-validation').html("");
                $('#edit-property-validation').show();
                $('#edit-property-validation').addClass('alert alert-danger fade show')
                $.each(response.errors, function (key, err_value) {
                    //   $(form).find('span.'+key+'_error').text(err_value[0]);
                    $('#edit-property-validation').append('<li>*'+err_value+'</li>');
                });   
                $('#edit-property-validation').append('<button type="button" class="close" id="remove-validation" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
                
                console.log(response);
            } else if(response.status == 200) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: response.success,
                  showConfirmButton: false,
                  timer: 1500
                })
                setInterval(function() {
                  window.location = '/account';
                }, 1500);
            }
          }
        });
    });

    $('.is_sold_property').click(function() {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'danger',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                var id = $('#user_property_info_id').val()
                var fd = new FormData();
                fd.append('user_property_id', id);
                fd.append('_token', '{{ csrf_token() }}');
                
                $.ajax({
                    url: "{{ route('account.soldProperty') }}",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Sold!',
                            text: "Your property is sold.",
                            icon: 'success',
                        }).then((result2) => {
                        if (result2.isConfirmed) {
                           window.location.reload();
                        }
                        })
                    }
                });

                
            }
        })
    })

    $('.user_delete_property').click(function() {

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

            var id = $('#user_property_info_id').val()
            var fd = new FormData();
            fd.append('user_property_id', id);
            fd.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('account.delUserProperty') }}",
                method: 'POST',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Sold!',
                        text: "Your property is sold.",
                        icon: 'success',
                    }).then((result2) => {
                    if (result2.isConfirmed) {
                    window.location.reload();
                    }
                    })
                }
            });
            }
        })

       
    });

    $('#chng_user_pass_form').submit(function(e) {
        e.preventDefault()
        var form = this;
        var fd = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
          method: $(form).attr('method'),
          data: fd,
          processData: false,
          contentType: false,
          success: function(response) {
            // console.log(response)

            if(response.status === 400) {
                $('#user-password-validation').html("");
                $('#user-password-validation').show();
                $('#user-password-validation').addClass('alert alert-danger fade show')
                $.each(response.errors, function (key, err_value) {
                    $('#user-password-validation').append('<li>*'+err_value+'</li>');
                }); 
                $('#user-password-validation').append('<button type="button" class="close" id="remove-validation" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
            } else if(response.status === 401) {
                toastr.error(response.error);
                $('#user-password-validation').hide();
            } else if(response.status === 200) {
                toastr.success(response.success);
                form.reset();
                $('#user-password-validation').hide();
            }
            
          }
        });
       
         
    });

    $('#user_settings_form').submit(function(e) {
        e.preventDefault();
        var form = this;
        var fd = new FormData(form);

        $.ajax({
          url: $(form).attr('action'),
          method: $(form).attr('method'),
          data: fd,
          processData: false,
          contentType: false,
          success: function(response) {
            // console.log(response)

            if(response.status === 400) {
                $('#user-info-validation').html("");
                $('#user-info-validation').show();
                $('#user-info-validation').addClass('alert alert-danger fade show')
                $.each(response.errors, function (key, err_value) {
                    $('#user-info-validation').append('<li>*'+err_value+'</li>');
                }); 
                $('#user-info-validation').append('<button type="button" class="close" id="remove-validation" aria-label="Close"><span aria-hidden="true">&times;</span></button>')
            } else if(response.status === 401) {
                toastr.error(response.error);
                $('#user-info-validation').hide();
            } else if(response.status === 200) {
                toastr.success(response.success);
                window.location.reload();
            }
            
          }
        });
    });

    $('#show-location-btn').click(function() {
        $('#show-location-div').toggleClass('d-none');
        
    })

    $(document).on('click', '#remove-validation', function() {
        $('#new-property-validation').hide();
        $('#edit-property-validation').hide();
        $('#user-password-validation').hide();
        $('#user-info-validation').hide();
        
    })

    $('#change_profile_pic').change(function(e) {

        const file = e.target.files[0];
        
        let fd = new FormData();
        fd.append('change_profile_pic', file);
        fd.append('user_id', $('#user_id').val());
        fd.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('account.changeProfilePic') }}",
            method: 'post',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.status === 400) {
                    $.each(response.errors, function (key, err_value) {
                    toastr.error(err_value) 
                    });  
                } else if(response.status === 200) {
                    let url = window.URL.createObjectURL(file);
                    $('#change_profile_pic_preview').attr('src', url);
                    $('.user-profile-icon').attr('src', url);
                    toastr.success(response.messages) 
                }
            }
        });

        // alert($('#user_id').val())
    })

    let activate_email;
    $('.activate_email_btn').click(function(e) {
        e.preventDefault();
        let fd = new FormData();
        fd.append('email', $('.activate_email_input').val());
        fd.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('auth.emailVerify') }}",
            method: 'post',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function(res) {
                activate_email = bootbox.dialog({
                        message: `<div class="text-center"><i class="fas fa-spin
                        fa-spinner"></i> Loading...</div>`,
                        closeButton: false
                });
            },
            dataType: 'json',
            success: function(res) {

                if(res.status == 200) {

                    $('.activate_email_btn').prop('disabled',true);
                    $('.activate_email_btn').addClass('not-allowed');
                    activate_email.modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.success,
                        showConfirmButton: false,
                        timer: 3000
                    })
    
                }
                
            }
            
        });
    });

})
</script>
@endpush


