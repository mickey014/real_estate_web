<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agent;
use App\Models\Category;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CustomAuthController extends Controller
{



    // Handle register user ajax request
    public function registerUser(Request $request) {    
        $validator = Validator::make($request->all(),[
            'password'=>'required|min:8',
            'email'=>'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users|unique:admin',
            'name'=>'required|min:4',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        }  else {
            $user = new User();
            $user->name = $request->name;
            $user->remember_token = null;
            $user->contact_no = null;
            $user->images = null;
            $user->email = $request->email;
            $user->username = null;
            $user->address = null;
            $user->password = Hash::make($request->password);
            $user->response_time = null;
            $user->response_rate = null;
            $user->save();
            auth()->login($user);
            
            return response()->json([
                'status'=>200,
                'error'=>'You are now registered.'
            ]);

            
        }
    }

    public function loginUser(Request $request) {
        $validator = Validator::make($request->all(),[
            'password'=>'required|min:8',
            'email'=>'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        ]);

        

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        } else {
            
            $user = User::where('email',$request->email)->first();
            $agent = Agent::where('email',$request->email)->first();
            
            if(auth()->attempt($request->only(['email', 'password']))) {
                


               

                if(Hash::check($request->password, $user->password)) {
                    auth()->login($user);
                    if(isset($request->remember)&& !empty($request->remember)) {
                        setcookie('email', $request->email);
                        setcookie('password', $request->password, time()+3600);
                    } else {
                        setcookie('email', '');
                        setcookie('password', '');
                    }
                    
                    
                    return response()->json([   
                        'status'=>200,
                        'success'=>'Logged in Successfully!'
                    ]);
                } else {
                    return response()->json([   
                        'status'=>401,
                        'error'=>'Email or Password is incorrect!'
                    ]);
                }
                
            } else {
                return response()->json([
                    'status'=>401,
                    'error'=>'Username or password is incorrect.'
                ]);
            }
            


        }

    }

    public function logoutUser() {
        auth()->logout();
        
        return redirect('/');
        
    }

    public function forgotPasswordLoad() {

        if(!auth()->user()) {
            $property_types = Category::select('name')->get();
            return view('forgot-password',compact('property_types'));
        } else {
            abort(404);
        }

        
    }

    public function forgotPasswordValidation(Request $request) {
        try {


            $validator = Validator::make($request->all(),[
                'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|exists:users',
            ],[ 
                'required' => 'Your email is required.',
                'regex' => 'Your email format is invalid.',
                'exists' => 'Your email is not registered.'
            ]); 

            if($validator->fails()) {
            
                return response()->json([
                    'status'=>400,
                    'errors'=> $validator->getMessageBag()
                ]);
    
            } else { 

                return response()->json([
                    'status'=>200,
                ]);
    
                
                
            }

            
        } catch (\Exception $e) {
            
            return response()->json([
                'status'=>400,
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function forgotPasswordMail(Request $request) {
        $user = User::where('email', $request->email)->first();

        $token = Str::random(40);
        $domain = URL::to('/');
        $url = $domain.'/reset-password?token='.$token;

        $data['url'] = $url;
        $data['user'] = $user->name;
        $data['email'] = $request->email;
        $data['title'] = 'Password Reset';
        $data['body'] = 'We\'re sending you this email because you requested a password reset. Please click on below link to create a new password.';

        

        if(Mail::send('forgot-password-mail', ['data' => $data],function($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        })) {
            $dateTime = Carbon::now()->format('Y-m-d H:i:s');

            PasswordReset::updateOrCreate(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $dateTime,
                ]
            );

            return response()->json([
                'status'=>200,
                'success'=> 'Please kindly check your email to reset your password.'
            ]);
        } else {
            return response()->json([
                'status'=>401,
                'success'=> 'Mail is not available right now.'
            ]);
        }
    }

    public function resetPasswordLoad(Request $request) {

        if(!auth()->user()) {
            $reset_data = PasswordReset::where('token', $request->token)->get();
            $property_types = Category::select('name')->get();
    
            if(isset($request->token) && count($reset_data) > 0) {
                $user = User::where('email', $reset_data[0]['email'])->get();
    
                return view('reset-password', compact('user','property_types'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
        
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'cpassword' => 'required|string|same:password',
            'password' => 'required|string|min:6',
        ]); 

        if($validator->fails()) {
            
            return response()->json([
                'status'=>400,
                'errors'=> $validator->getMessageBag()
            ]);

        }  else {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();
    
            PasswordReset::where('email',$user->email)->delete();
            
            return response()->json([
                'status'=>200,
                'success'=> 'Your Password has been reset successfully.'
            ]);
        }
        

        
    }
}
