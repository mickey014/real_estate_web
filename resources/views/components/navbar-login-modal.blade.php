	<!-- Tabs -->
    <section id="navbar-login-tabs" class="login-navbar-section d-none" x-show="open"
    x-transition>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 ">
                    <nav class="tabs-login">
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#login-profile" role="tab" aria-controls="nav-home" aria-selected="true">Login</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#register-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Signup</a>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="login-profile" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row border p-3 bg-white shadow box-area">
                                {{-- Left Box --}}
                                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: rgb(16, 172, 132);">
                                    <div class="featured-image mb-3">
                                     <img src="{{ URL('storage/1.png') }}" class="img-fluid" style="width: 250px;">
                                    </div>
                                    <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
                                    <small class="text-white text-wrap text-center" style="width: 17rem;">Join experienced Designers on this platform.</small>
                                </div> 
                                <!-------------------- ------ Right Box ---------------------------->
                                <div class="col-md-6 right-box">
                                    <div class="row align-items-center">
                                        <div class="header-text mb-4">
                                            <h2>Hello, Again</h2>
                                            <p>We are happy to have you back.</p>
                                            <a href="javascript:void(0)" class="close-login-modal" 
                                            @click="open = false"
                                            >
                                            <i class='bx bx-x'></i>
                                            </a>
                                        </div>

                                        <form action="{{ route('auth.loginUser') }}" method="POST" class="w-100" id="login-user-modal">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control bg-light fs-6" placeholder="Email Address" name="email" id="email"
                                                @if(isset($_COOKIE['email']))
                                                        value="{{ $_COOKIE['email'] }}"
                                                @endif 
                                                >
                                            </div>  
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control bg-light log-password" placeholder="Password"  name="password" id="password"
                                                @if(@isset($_COOKIE['password']))
                                                        value="{{ $_COOKIE['password'] }}"
                                                @endif
                                                >
                                                <i class="fa-regular fa-eye log-toggle-password toggle-password"></i>
                                            </div>
                                          
                                            <div class="input-group mb-2 d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" 
                                                    @if(isset($_COOKIE['email']) && isset($_COOKIE['password']))
                                                       checked
                                                    @endif
                                                    >
                                                    <label for="remember" class="form-check-label text-secondary"><small>Remember Me</small></label>
                                                </div>
                                                <div class="forgot">
                                                    <small><a href="{{ URL('forgot-password') }}" class="text-main-color">Forgot Password?</a></small>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <button type="submit" class="btn btn-lg w-100 fs-6 login-btn text-white" id="login-register-btn">Login</button>
                                            </div>

                                            <div>
                                                
                                                <p>
                                                    Don't have an account?
                                                    <a id="signup-tab" href="#register-profile" data-toggle="tab" role="tab">Sign up</a>
                                                </p>

                                            </div>

                                        </form>

                                            
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="tab-pane fade" id="register-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row border p-3 bg-white shadow sign-up-box-area">
    <!-------------------- ------ Right Box ---------------------------->
                                <div class="col-md-6 px-0 right-box">
                                    <div class="row align-items-center w-100">
                                        <div class="header-text mb-0">
                                            <h2 class="m-0">Register for free</h2>
                                            <p>Make sure your account is secure.</p>
                                            
                                        </div>
                                        <form action="{{ route('auth.registerUser') }}" method="POST" class="w-100" id="register-user-modal">
                                            @csrf
                                            <div class="input-group mb-2 col-sm-12 p-0 mb-3">
                                                <input type="text" class="form-control bg-light name w-0" placeholder="Name" name="name" id="name">
                                            </div>

                                            <div class="input-group mb-2 col-sm-12 p-0 mb-3">
                                                <input type="text" class="form-control bg-light fs-6" placeholder="Email Adress" name="email" id="email">  
                                            </div>

                                            <div class="input-group mb-3 col-sm-12 p-0 mb-3">
                                                <input type="password" class="form-control bg-light reg-password fs-6" placeholder="Password" name="password" id="password">
                                                <i class="fa-regular fa-eye reg-toggle-password toggle-password"></i>
                                            </div>

                                            <div>
                                                
                                                <p>
                                                    Have an account?
                                                    <a id="login-tab" href="#login-profile" data-toggle="tab" role="tab">Login</a>
                                                </p>

                                            </div>

                                            <div class="input-group mb-2 col-sm-12 p-0 mb-3">
                                                <button type="submit" class="btn btn-lg w-100 fs-6 login-btn text-white" id="signup-register-btn">Signup</button>
                                            </div>

                                            

                                        </form>
                                    </div>
                                </div> 
    
                                {{-- Left Box --}}
                                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: rgb(16, 172, 132);">
                                    <div class="featured-image mb-3">
                                     <img src="{{ URL('storage/user-sign-up.png') }}" class="img-fluid" style="width: 250px;">
                                    </div>
                                    <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be a Member</p>
                                    <small class="text-white text-wrap text-center" style="width: 17rem;" >Purchased with common sense, paid for in full, and managed with reasonable care.</small>
                                    
                                </div> 
                                <a href="javascript:void(0)" class="signup-close-login-modal" 
                                    @click="open = false"
                                    >
                                    <i class='bx bx-x'></i>
                                </a>
                            </div>
                        </div>
    
                    </div>
                
                </div>
            </div>
        </div>
    </section>

{{-- @section('script')

    
@endsection --}}