@section('title', 'Reset Password')
@extends('layouts.app')
@section('content')


<header id="home" class="home">
    <x-navbar />
</header>


<section class="container forgot-password">
    <h1 class="text-center">Password Reset</h1>
    <div class="row justify-content-center align-items-center">

        <div class="col-md-6 col-md-offset">
            <form action="{{ route('auth.resetPassword') }}" class="card mt-4" method="POST" id="reset-password">
                @csrf
                <div class="card-body pb-0">
                    <div id="reset-errors"></div>
                    
                    <input type="hidden" name="id" value="{{ $user[0]['id'] }}">
                    <div class="form-group reset-wrapper-pass">
                        <label for="password">Password:</label>
                        <input class="form-control reset-pass" type="password" id="password" name="password">
                        <i class="fa-regular fa-eye reset-toggle-password"></i>
                    </div>
                    <div class="form-group reset-wrapper-cpass">
                        <label for="confirm-password">Confirm Password:</label>
                        <input class="form-control reset-cpass" type="password" id="cpassword" name="cpassword">
                        <i class="fa-regular fa-eye reset-toggle-cpassword"></i>
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn bg-primary-color" type="submit" id="btn-pword-reset">Submit</button>
                </div>
            </form>
            
        </div>
        
        
    </div>
</section>
@include('partials.footer')
@endsection

@push('scripts')
<script>
    $(document).ready(function(e) {

        let reset_password;

        $('.reset-toggle-password').click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $(".reset-pass");
            if (input.attr("type") === "password") {
            input.attr("type", "text");
            } else {
            input.attr("type", "password");
            }
        });

        $('.reset-toggle-cpassword').click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $(".reset-cpass");
            if (input.attr("type") === "password") {
            input.attr("type", "text");
            } else {
            input.attr("type", "password");
            }
        });
        
        $('#reset-password').submit(function(e) {
            e.preventDefault();
    
            $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',    
            success: function(res) {
                if(res.status == 400) {
                    
                    $('#reset-errors').html('');
                    $.each(res.errors, function (key, err_value) {
                    //   toastr.error(err_value) 
                        $('#reset-errors').append('<p class="text-danger p-0 m-0">'+err_value+'</p>');
                    });  
                     
                  
                } else if(res.status == 200) {
                    $('#reset-errors').html('');
                    if ( !$('#reset-errors').children().length > 0 ) {
                        $('#btn-pword-reset').prop('disabled',true);
                        $('#btn-pword-reset').addClass('not-allowed');
                        reset_password = bootbox.dialog({
                                message: `<div class="text-center"><i class="fas fa-spin
                                fa-spinner"></i> Loading...</div>`,
                                closeButton: false
                        });
                        setInterval(function() {
                            reset_password.modal('hide');
                            $('#btn-pword-reset').prop('disabled',false);
                            $('#btn-pword-reset').removeClass('not-allowed');
                            $(".reset-pass").val('');
                            $(".reset-cpass").val('');
                        }, 800);

                        setInterval(function() {
                            window.location = '/'
                        }, 900);
                    }
                    
                    
                }
                
            }
            });
        })

        

        
        
    });
    
</script>
@endpush
