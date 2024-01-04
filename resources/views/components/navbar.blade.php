
<div x-data="{ open: false }">

  <nav class="animate navs" >
    <div class="container-fluid">
      <div class="left pl-2 flex-center">
        <!-- Logo -->
        <a href="/""><img class="logo" src="{{ URL('storage/logo.png') }}" alt=""></a>
      </div>
      <div class="menu-button hide right pointer">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="menu left">
        <div class="page-menu left">
          
          <li><a href="{{ URL('/buy') }}" class="nav-links">Buy</a></li>
          <li><a href="{{ URL('/rent') }}" class="nav-links">Rent</a></li>
          <li><a href="{{ URL('/our-team') }}" class="nav-links">Team</a></li>
          <li><a href="{{ URL('/our-services') }}" class="nav-links">Services</a></li>
          
          {{-- <div class="nav-pages">
            <ul class="navbar-nav">
                <li class="nav-item" id="nav-pages-item">
                  <a class="nav-links dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    Pages
                  </a>
                  <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item px-4" href="{{ URL('about-us') }}">About Us</a>
                    <a class="dropdown-item px-4" href="{{ URL('our-team') }}">Team</a>
                    <a class="dropdown-item px-4" href="{{ URL('our-services') }}">Services</a>
                    <a class="dropdown-item px-4" href="{{ URL('contact-us') }}">Contact Us</a>
                  </div>
              </li>   
            </ul>
          </div> --}}

        </div>
        <div class="registration nav-user-profile-pull-right">

          @if(!auth()->check()) 
          <div class="join-us">
            <!-- Join Us Button -->
            <li class="pointer animate">
              <a @click="open = !open" 
              class="join-us-link" href="javascript:void(0)">
                <i class='bx bx-user'></i>Join Us
              </a>
			      </li>

          </div>

          @else
          
            <!-- Get Started Button -->
            
          <a href="/account" id="add-listing-btn">
            <img class="add-listing-icon" src="{{ URL('storage/add_home_white.png') }}" alt="">
            Add Listing
          </a>
           

          <div class="nav-user-profile" id="navbar-list-4">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:;" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                  @if(auth()->user()->images != null)
                  <img class="user-profile-icon" alt="{{ auth()->user()->images }}" src="{{ URL('uploads/profile_pic/'). '/' .auth()->user()->images }}" data-toggle="tooltip" data-placement="bottom" title="Hit me!">
                  @else
                  <img class="user-profile-icon" alt="?" src="{{ URL('uploads/profile_pic/businessman.png') }}" data-toggle="tooltip" data-placement="bottom" title="Hit me!">
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right py-0 pt-4" aria-labelledby="navbarDropdownMenuLink">
                  <a href="javascript:;" class="dropdown-item-user-name px-4">
                    @if(auth()->user()->images != null)
                    <img class="user-profile-icon" alt="{{ auth()->user()->images }}" src="{{ URL('uploads/profile_pic/'). '/' .auth()->user()->images }}">
                    @else
                    <img class="user-profile-icon" alt="?" src="{{ URL('uploads/profile_pic/businessman.png') }}">
                    @endif
                    <span id="navbar-nav-user-profile">{{ auth()->user()->name }}</span>
                  </a>

                  <hr class="px-4 mb-0">
                  
                  <a class="dropdown-item px-4 d-flex align-items-center" href="{{ route('account') }}"><i class='bx bxs-dashboard'></i> Dashboard</a>
                  <a class="dropdown-item px-4 d-flex align-items-center" href="{{ route('account') }}"><i class='bx bxs-user-detail'></i> Edit Profile</a>
                  <a class="dropdown-item px-4 d-flex align-items-center nav-user-settings-privacy" id="nav-user-settings-privacy" href="{{ URL('account') }}""><i class='bx bx-cog' ></i> Settings & Privacy</a>
                  <a class="dropdown-item px-4 d-flex align-items-center" href="{{ route('auth.logoutUser'); }}"><i class='bx bx-exit'></i> Logout</a>
                </div>
              </li>   
            </ul>
          </div>
          
          @endif

        </div>
      </div>
    </div>
  </nav>

  @guest
  <x-navbar-login-modal />
  @endguest

</div>

@guest
@push('scripts')
<script> 
$(document).ready(function() {

  $('#navbar-login-tabs').toggleClass('d-none');

  $('.log-toggle-password').click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $(".log-password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  
  $('.reg-toggle-password').click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $(".reg-password");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // register user
  $('#register-user-modal').submit(function(e){
      e.preventDefault();
      $.ajax({
          url: '{{ route('auth.registerUser') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',    
          success: function(res) {
              
              if(res.status == 400) {
                  $.each(res.errors, function (key, err_value) {
                      toastr.error(err_value) 
                  });   
              } else if(res.status == 200) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: res.error,
                    showConfirmButton: false,
                    timer: 1500
                  })
                  setInterval(function() {
                    window.location = '/'
                  }, 1500);
              }
              // console.log(res.status);
          }
      });
  });

  // login user
  $('#login-user-modal').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '{{ route('auth.loginUser') }}',
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json',    
        success: function(res) {
            // console.log(res)
            if(res.status == 400) {
                $.each(res.errors, function (key, err_value) {
                    toastr.error(err_value) 
                });   
                // toastr.error(res.errors);   
            } else if(res.status == 401) {
                toastr.error(res.error);
            } else if(res.status == 200) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: res.success,
                  showConfirmButton: false,
                  timer: 1500
                })
                setInterval(function() {
                  window.location = '/';
                }, 1500);
            }
            // console.log(res)    
            
        }
    });
  });
})
</script>
@endpush
@endguest

