
@section('title', 'Forgot Password')
@extends('layouts.app')
@section('content')

<header id="home" class="home">
    <x-navbar />
</header>


<section class="container forgot-password">
    <div class="row justify-content-center align-items-center">
        <img src="{{ URL('storage/forgot-password.png') }}" alt="">
    </div>

    <div class="row justify-content-center align-items-center">
        
        <div class="col-md-5 forgot">
            
            <h2>Forgot your password?</h2>
            <p>Change your password in three easy steps. This will help you to secure your password!</p>
            <ul>
            <li><span>1.</span> Enter your email address below.</li>
            <li><span>2.</span>Our system will send you a link.</li>
            <li><span>3.</span>Use the link to reset your password.</li>
            </ul>

        </div>	
        <div class="col-md-5">
            
            
            <form action="{{ route('auth.forgotPasswordValidation') }}" class="card mt-4" method="POST" id="forgot-password">
                @csrf
                <div class="card-body pb-0">
                    
                    <div id="forgot-errors"></div>
                    
                    <div class="form-group">
                        <label for="email">Enter your email address</label>
                        <input class="form-control" type="text" id="email" name="email" autofocus>
                        <small class="form-text text-muted">Enter the email address you used during the registration on our system, Then we'll email a link to this address.</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn bg-primary-color" type="submit" id="btn-pword-forgot">Password Reset</button>
                </div>
            </form>
        </div>
        
        
    </div>
</section>

@include('partials.footer')
@endsection

@push('scripts')
<script>
    
$(document).ready(function() {

    let send_email_loading;
    
    $('#forgot-password').submit(function(e) {
        e.preventDefault();        
        
            $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                
                if(res.status == 400) {
                    $('#forgot-errors').html('');
                    $.each(res.errors, function (key, err_value) {
                        $('#forgot-errors').append('<p class="text-danger p-0 m-0">'+err_value+'</p>');
                    });  

                    
                } else if(res.status == 401) {
                    $('#forgot-errors').html('');
                    $('#forgot-errors').append('<p class="text-danger p-0 m-0">'+res.error+'</p>');
                } else if(res.status == 200) {
                    
                    $('#forgot-errors').html('');
                    if ( !$('#forgot-errors').children().length > 0 ) {
                        $('#btn-pword-forgot').prop('disabled',true);
                        $('#btn-pword-forgot').addClass('not-allowed');
                        send_email_loading = bootbox.dialog({
                            message: `<div class="text-center"><i class="fas fa-spin
                            fa-spinner"></i> Loading...</div>`,
                            closeButton: false
                        });
                        sendForgotEmail();
                    }
   
                }

            }
            
            });
        
    })


    function sendForgotEmail() {
        $.ajax({
            url: '{{ route('auth.forgotPasswordMail') }}',
            method: 'post',
            data: $('#forgot-password').serialize(),
            dataType: 'json',
            success: function(res) {
                
                if(res.status == 401) {
                    $('#forgot-errors').html('');
                    $('#forgot-errors').append('<p class="text-danger p-0 m-0">'+res.error+'</p>');
                } else if(res.status == 200) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.success,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    send_email_loading.modal('hide');
                    $('#btn-pword-forgot').prop('disabled',false);
                    $('#btn-pword-forgot').removeClass('not-allowed');
                    $('#forgot-password').find('#email').val('');
                    $('#forgot-password').find('#email').focus();
                }
            }
        })
    }

    
    
});



</script>
@endpush
