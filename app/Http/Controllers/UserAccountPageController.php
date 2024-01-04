<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;


class UserAccountPageController extends Controller
{
    //
    public function index() {
        

        $property_types = Category::select('name', 'description')->get();
        $user_total_listed = Property::where('user_id', auth()->user()->_id)
                        ->where('is_sold', null)
                        ->orderBy('_id', 'desc')
                        ->get();
        
        return view('users/user-account',compact('property_types','user_total_listed'));
    }

    public function UserPropertyTotalListed() {
        $user_total_listed = Property::where('user_id', auth()->user()->id)
                        ->where('is_sold', null)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->count();
        return response()->json([
            'user_total_listed'=>$user_total_listed,
        ]);
    }

    public function GetUserPropertyInfo(Request $request) {

        $user_property_info = Property::where('_id', $request->user_property_id)
        ->get();
        return response()->json([
            'user_property_info'=>$user_property_info,
        ]);
    }

    public function addNewProperty(Request $request) {

        //print_r($_POST);

        $validator = Validator::make($request->all(),[
            'property_name'=>'required|min:4|unique:property',
            'property_desc' => 'required|min:10',
            'floor_plan1' => [
                Rule::requiredIf($request->property_floors >= 1),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            'floor_plan2' => [
                Rule::requiredIf($request->property_floors >= 2),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            'floor_plan3' => [
                Rule::requiredIf($request->property_floors == 3),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            'property_area' => 'required|integer',
            'property_size' => 'required|integer',
            'property_before_price' => 'required|integer',
            'property_after_price' => 'required|integer',
            'property_year_built' => 'required',
            'featured_img' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img1' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img2' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img3' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img4' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'street_address' => 'required|min:4|unique:property',
            'provinces' => 'required',
            'barangays' => 'required',
            'cities' => 'required',
            'postal_code' => 'required|integer',
        ],[
            'property_name.required' => "Property name is required.",
            'property_name.min' => "Property name must be atleast 4 characters.",
            'property_desc.required' => "Description is required.",
            'property_desc.min' => "Description must be atleast 10 characters.",
            'property_area.required' => "Property area is required.",
            'property_area.integer' => "Property area must not contain letters.",
            'property_size.required' => "Property size is required.",
            'property_size.integer' => "Property size must not contain letters.",
            'property_before_price.required' => "Before price is required.",
            'property_after_price.required' => "After price is required.",
            'street_address' => "Address is required",
            'provinces' => "Province is required",
            'barangays' => "Barangay is required",
            'cities' => "Cities is required",
            'postal_code' => "Postal Code is required",
            'postal_code.integer' => "Postal code must not contain letters.",
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        }  else {
            $property = new Property();
                $property->user_id = $request->user_id;
                $property->property_type = $request->property_type;
                $property->property_status = $request->property_status;
                $property->is_featured = intval($request->is_featured);
                $property->is_sold = null;
                $property->is_rent_paid = null;
                $property->property_name = $request->property_name;
                $property->property_name_slug = Str::slug($request->property_name);
                $property->property_desc = $request->property_desc;
                $property->property_floors = intval($request->property_floors);

                if($request->hasFile('floor_plan1')) {
                    $file = $request->file('floor_plan1');
                    $ext = $file->getClientOriginalExtension();
                    $floor_plan1_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $floor_plan1_file_name);
                } else {
                    $floor_plan1_file_name = null;
                }
                if($request->hasFile('floor_plan2')) {
                    $file = $request->file('floor_plan2');
                    $ext = $file->getClientOriginalExtension();
                    $floor_plan2_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $floor_plan2_file_name);
                }else {
                    $floor_plan2_file_name = null;
                }
                if($request->hasFile('floor_plan3')) {
                    $file = $request->file('floor_plan3');
                    $ext = $file->getClientOriginalExtension();
                    $floor_plan3_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $floor_plan3_file_name);
                }
                else {
                    $floor_plan3_file_name = null;
                }
                $property->property_floor_img = [
                    'floor_plan1' => $floor_plan1_file_name,
                    'floor_plan2' => $floor_plan2_file_name,
                    'floor_plan3' => $floor_plan3_file_name,
                ];

                $property->property_bed = intval($request->property_bed);
                $property->property_bath = intval($request->property_bath);
                $property->property_rooms = intval($request->property_rooms);
                $property->property_garages = intval($request->property_garages);
                $property->property_area = intval($request->property_area);
                $property->property_size = intval($request->property_size);
                $property->property_year_built = $request->property_year_built;
                $property->property_before_price = intval($request->property_before_price);
                $property->property_after_price = intval($request->property_after_price);
                $property->amenities = [
                    'aircon' => intval($request->aircon),
                    'emergency_exit' => intval($request->emergency_exit),
                    'fully_furnished' => intval($request->fully_furnished),
                    'semi_furnished' => intval($request->semi_furnished),
                    'gym' => intval($request->gym),
                    'kitchen' => intval($request->kitchen),
                    'laundry' => intval($request->laundry),
                    'lawn' => intval($request->lawn),
                    'meeting_rooms' => intval($request->meeting_rooms),
                    'onsite_parking' => intval($request->onsite_parking),
                    'shared_internet' => intval($request->shared_internet),
                ];
                
                // $property->featured_img = implode('|', $featured_img);
                if($request->hasFile('featured_img')) {
                    $file = $request->file('featured_img');
                    $featured_img_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $featured_img_file_name);
                }
                if($request->hasFile('gallery_img1')) {
                    $file = $request->file('gallery_img1');
                    $gallery1_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $gallery1_file_name);
                }
                if($request->hasFile('gallery_img2')) {
                    $file = $request->file('gallery_img2');
                    $gallery2_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $gallery2_file_name);
                }
                if($request->hasFile('gallery_img3')) {
                    $file = $request->file('gallery_img3');
                    $gallery3_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $gallery3_file_name);
                }
                if($request->hasFile('gallery_img4')) {
                    $file = $request->file('gallery_img4');
                    $gallery4_file_name = $file->getClientOriginalName();
                    $file->move('uploads/new_property/', $gallery4_file_name);
                }
                $property->property_gallery = [
                    'featured_img' => $featured_img_file_name,
                    'gallery_img1' => $gallery1_file_name,
                    'gallery_img2' => $gallery2_file_name,
                    'gallery_img3' => $gallery3_file_name,
                    'gallery_img4' => $gallery4_file_name,
                ];
                $property->location = [
                    'provinces' => $request->provinces,
                    'cities' => $request->cities,
                    'barangays' => $request->barangays,
                    'postal_code' => $request->postal_code,
                    'street_address_slug' => Str::slug($request->street_address),
                    'street_address' => $request->street_address,
                ];
                
                $property->save();

                return response()->json([
                    'status'=>200,
                    'success'=>'New property has been added.'
                ]);
           
        }
    }

    // handlee change profile of users ajax request
    public function changeProfilePic(Request $request) {
        $ch_user_id = $request->user_id;
        $validator = Validator::make($request->all(),[
            'change_profile_pic' => 'mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        } else {
            if($request->hasFile('change_profile_pic')) {
                $file = $request->file('change_profile_pic');
                
                $file = $request->file('change_profile_pic');
                $profile_pic = $file->getClientOriginalName();
                $file->move('uploads/profile_pic/', $profile_pic);
    
            }
            User::where('_id', $ch_user_id)->update([
                'images' => $profile_pic
            ]);
            return response()->json([
                'status' => 200,
                'messages' => 'Change Profile Done!'
            ]);
        }

        
        

       
    }

    public function updateProperty(Request $request) {
        // 'floor_plan1' => 
        // Rule::requiredIf($request->property_floors == 0 && $request->old_floor_plan1 == null ), Rule::requiredIf($request->floor_plan1 == null ),'image|mimes:jpeg,png,jpg,svg|max:2048' ,
        // Rule::requiredIf($request->floor_plan1 == null ),
        $validator = Validator::make($request->all(),[
            
            'floor_plan1' => [
                Rule::requiredIf($request->property_floors >= 1 && $request->old_floor_plan1 == null),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            'floor_plan2' => [
                Rule::requiredIf($request->property_floors >= 2 && $request->old_floor_plan2 == null),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            'floor_plan3' => [
                Rule::requiredIf($request->property_floors == 3 && $request->old_floor_plan3 == null),
                'image',
                'mimes:jpeg,png,jpg,svg',
                'max:2048',     
            ],
            
            'property_area' => 'integer',
            'property_size' => 'integer',
            'property_before_price' => 'integer',
            'property_after_price' => 'integer',
            'featured_img' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img1' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img2' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img3' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'gallery_img4' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'postal_code' => 'integer',
        ],[
            'floor_plan1.required' => 'Floor Plan1 is required.',
            'floor_plan2.required' => 'Floor Plan2 is required.',
        ]

        );

        if($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        } else {
        
            $property = Property::find($request->user_property_info_id);
            $property->user_id = $request->user_id;
            
            $property->property_type = $request->property_type;
            $property->property_status = $request->property_status;
            $property->is_featured = intval($request->is_featured);
            $property->property_name = $request->property_name;
            $property->property_name_slug = Str::slug($request->property_name);
            $property->property_desc = $request->property_desc;
            $property->property_floors = intval($request->property_floors);

            if($request->hasFile('floor_plan1')) {
                $file = $request->file('floor_plan1');
                $floor_plan1_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $floor_plan1_file_name);
                
            } else {
                $floor_plan1_file_name = $request->old_floor_plan1;
            }

            if($request->hasFile('floor_plan2')) {
                $file = $request->file('floor_plan2');
                $floor_plan2_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $floor_plan2_file_name);
                
            }else {
                $floor_plan2_file_name = $request->old_floor_plan2;
            }
            if($request->hasFile('floor_plan3')) {
                $file = $request->file('floor_plan3');
                $floor_plan3_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $floor_plan3_file_name);
                
            }
            else {
                $floor_plan3_file_name = $request->old_floor_plan3;
            }
            $property->property_floor_img = [
                'floor_plan1' => $floor_plan1_file_name,
                'floor_plan2' => $floor_plan2_file_name,
                'floor_plan3' => $floor_plan3_file_name,
            ];

            $property->property_bed = intval($request->property_bed);
            $property->property_bath = intval($request->property_bath);
            $property->property_rooms = intval($request->property_rooms);
            $property->property_garages = intval($request->property_garages);
            $property->property_area = intval($request->property_area);
            $property->property_size = intval($request->property_size);
            $property->property_year_built = $request->property_year_built;
            $property->property_before_price = intval($request->property_before_price);
            $property->property_after_price = intval($request->property_after_price);
            $property->amenities = [
                'aircon' => intval($request->aircon),
                'emergency_exit' => intval($request->emergency_exit),
                'fully_furnished' => intval($request->fully_furnished),
                'semi_furnished' => intval($request->semi_furnished),
                'gym' => intval($request->gym),
                'kitchen' => intval($request->kitchen),
                'laundry' => intval($request->laundry),
                'lawn' => intval($request->lawn),
                'meeting_rooms' => intval($request->meeting_rooms),
                'onsite_parking' => intval($request->onsite_parking),
                'shared_internet' => intval($request->shared_internet),
            ];
            
            // $property->featured_img = implode('|', $featured_img);
            if($request->hasFile('featured_img')) {
                $file = $request->file('featured_img');
                $featured_img_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $featured_img_file_name);
                
            } else {
                $featured_img_file_name = $request->old_featured_img;
            }
            if($request->hasFile('gallery_img1')) {
                $file = $request->file('gallery_img1');
                $gallery1_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $gallery1_file_name);
                
            }else {
                $gallery1_file_name = $request->old_gallery_img1;
            }
            if($request->hasFile('gallery_img2')) {
                $file = $request->file('gallery_img2');
                $gallery2_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $gallery2_file_name);
                
            } else {
                $gallery2_file_name = $request->old_gallery_img2;
            }
            if($request->hasFile('gallery_img3')) {
                $file = $request->file('gallery_img3');
                $gallery3_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $gallery3_file_name);
                
            } else {
                $gallery3_file_name = $request->old_gallery_img3;
            }
            if($request->hasFile('gallery_img4')) {
                $file = $request->file('gallery_img4');
                $gallery4_file_name = $file->getClientOriginalName();
                $file->move('uploads/new_property/', $gallery4_file_name);
                
            }
            else {
                $gallery4_file_name = $request->old_gallery_img4;
            }

            $property->property_gallery = [
                'featured_img' => $featured_img_file_name,
                'gallery_img1' => $gallery1_file_name,
                'gallery_img2' => $gallery2_file_name,
                'gallery_img3' => $gallery3_file_name,
                'gallery_img4' => $gallery4_file_name,
            ];
            $property->location = [
                'provinces' => $request->provinces,
                'cities' => $request->cities,
                'barangays' => $request->barangays,
                'postal_code' => $request->postal_code,
                'street_address_slug' => Str::slug($request->street_address),
                'street_address' => $request->street_address,
            ];
            
            $property->update();

            return response()->json([
                'status'=>200,
                'success'=>'Property updated!'
            ]);
        }
    }

    public function soldProperty(Request $request) {
        
        $property = Property::find($request->user_property_id);
        $property->is_sold = 1;
        $property->update();
        
    }

    public function delUserProperty(Request $request) {
        // print_r($_POST);
        $property_id = $request->user_property_id;
        $del_property = Property::find($property_id);
        $del_property->destroy($property_id);
    }

    public function chngUserPass(Request $request) {

        $validator = Validator::make($request->all(),[
            'user_old_password' => [
                'required', function($attribute, $value, $fail) {
                    if(!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Current password is incorrect'));
                    }
                },  
                'min:8',
            ],
            'user_new_password' => 'required|min:8',
            'user_confirm_password' => 'required|same:user_new_password',
        ],[
            'user_old_password.required' => 'Enter your current password',
            'user_old_password.min' => 'Current password must have atleast 8 characters',
            'user_new_password.required' => 'Enter new password',
            'user_new_password.min' => 'New password must have atleast 8 characters',
            'user_confirm_password.required' => 'Enter your current password',
            'user_confirm_password.same' => 'Your new password is not matched!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
            
        } else {
            $user_change_pass = User::find(Auth::user()->id)->update(['password' => Hash::make($request->user_new_password)]);

            if($user_change_pass) {
                return response()->json([
                    'status'=>200,
                    'success'=> 'Your password has been changed!'
                ]);
            } else {
                return response()->json([
                    'status'=> 401,
                    'error'=> 'Something went wrong!, Please try again later.'
                ]);
            }
        }

        

    }

    public function chngUserInfo(Request $request) {



        $validator = Validator::make($request->all(),[
            'name'=>'required|min:4',
            'username'=>[
                'required',
                'min:6',
                'max:32',
                'unique:users,username,'.auth()->user()->id.',_id',
                'unique:admin,username,'.auth()->user()->id.',_id',
            ],
            'email'=> [
                'required',
                'min:10',
                'max:32',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'unique:users,email,'.auth()->user()->id.',_id',
                'unique:admin,email,'.auth()->user()->id.',_id',
            ],
            'contact_no' => [
                'required',
                'min:11',
                'max:11',
                'unique:users,contact_no,'.auth()->user()->id.',_id',
                'unique:admin,contact_no,'.auth()->user()->id.',_id',
            ],
            'response_time' => 'required|min:2|max:3',
            'response_rate' => 'required|min:2|max:3',
            'address' => 'required|min:5',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
            
        } else {
            $user_change_info = User::find(auth()->user()->id);
            $user_change_info->name = $request->name;
            $user_change_info->username = $request->username;
            $user_change_info->email = $request->email;
            $user_change_info->contact_no = $request->contact_no;
            $user_change_info->response_time = $request->response_time;
            $user_change_info->response_rate = $request->response_rate;
            $user_change_info->address = $request->address;
            $user_change_info->update();

            if($user_change_info) {
                return response()->json([
                    'status'=>200,
                    'success'=> 'Your information has been changed!'
                ]);
            } else {
                return response()->json([
                    'status'=> 401,
                    'error'=> 'Something went wrong!, Please try again later.'
                ]);
            }
        }
    }

    public function emailVerify(Request $request) {
        $user = User::where('email', $request->email)->first();

        // $token = Str::random(40);
        // $email_verified_at = $user->email_verified_at;
        $domain = URL::to('/');
        // $url = $domain.'/email-verified?token='.$token;

        $data['url'] = $domain.'/email-verify';
        // $data['email_verified_at'] = $email_verified_at;
        $data['user'] = $user->name;
        $data['email'] = $request->email;
        $data['title'] = 'Email Verification';
        $data['body'] = 'We\'re sending you this email to verify your identity, Please click on below link to become certified user.';

        

        if(Mail::send('email-verified-mail', ['data' => $data],function($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        })) {
            

            // $email_verified = User::find(auth()->user()->id);
            // $email_verified->email_verified_at = date('Y-m-d H:i:s');
            // $email_verified->update();

        

            return response()->json([
                'status'=>200,
                'success'=> 'Please kindly check your email to verify.'
            ]);
        } else {
            return response()->json([
                'status'=>401,
                'success'=> 'Mail is not available right now.'
            ]);
        }
    }

    public function emailVerifyLoad(Request $request) {
        
        // if(isset($request->token) && $request->email_verified_at == null) {
        //     return 'You are now officially member.';

        // } 

        // if(auth()->user()) {
        //     auth()->login($request->email);
        //     return $request->email_verified_at;
        // }
        // return view('email-verified');
        $email_verified = User::find(auth()->user()->id);
        if(auth()->user() && $email_verified->email_verified_at == null) {
            $email_verified->email_verified_at = date('Y-m-d H:i:s');
            $email_verified->update();
            return 'You are now officially member.';

        } else {
            abort(404);
        }
    }

    public function contactSeller(Request $request) {
        $user = User::where('email', $request->email)->first();

        $data['contact_email'] = auth()->user()->email;
        $data['contact_no'] = auth()->user()->contact_no;
        $data['user'] = $user->name;
        $data['email'] = $request->email;
        $data['title'] = 'Your Property';
        $data['body'] = 'We have a person that interested in your property and we\'ve been happy to talk about it or you can directly email them.';

        

        if(Mail::send('contact-seller-mail', ['data' => $data],function($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        })) {
            


            return response()->json([
                'status'=>200,
                'success'=> 'You send him/her email just wait for him/her response.'
            ]);
        } else {
            return response()->json([
                'status'=>401,
                'success'=> 'Mail is not available right now.'
            ]);
        }
    }
}
