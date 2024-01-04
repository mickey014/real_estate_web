<?php

$year_ago = \Carbon\Carbon::parse($single_property->created_at)->diffForHumans();

?>
@section('title', strtolower($single_property->property_name))
@extends('layouts.app')

  @section('content')
    
    <header id="home" class="home">
      <x-navbar />
    </header>

    <section class="page-header" style="background:url({{ URL('storage/page-header.jpg') }})">
      <div class="header-wrapper container">
        <h2>Property Detail</h2>
        <ul>
          <li><a href="/">Home</a></li>
          <li>></li>
          <li><a href="{{ URL('buy'). '/' .$single_property->property_name_slug  }}" class="active-page">Property Detail</a></li>
        </ul>  
      </div>
    </section>
    @if($single_property)
    <section class="listing-house-details" id="listing-house-details">

      <div class="listing-single-info-bgf">
        <div class="listing-single-info container">
          <div class="single-property-type">{{ $single_property->property_type }}</div>
          <div class="single-property-is-sold">{{ $single_property->property_status }}</div>
          {{-- <div class="single-property-is-sold">sold</div> --}}
          <p class="single-property-date-published"><i class="uil uil-clock"></i>{{ $year_ago }}</p>
        </div>
      </div>
      

    
      <div class="listing-house-details-bg">
        <div class="container">
          <div class="listing-single-info2">
            <h1 class="location-title">{{ $single_property->location['street_address'] }}</h1>
            <div class="single-property-price">
              <p>
                @if($single_property->property_status == "rent")
                <small class="previous-price">₱{{ $single_property->property_before_price }}/mo</small> 
                {{ $single_property->property_after_price }}/mo
                @else 
                <small class="previous-price">₱{{ $single_property->property_before_price }}</small> 
                {{ $single_property->property_after_price }}
                @endif
              </p>
            </div>
          </div>

          <div class="listing-single-info3">
            <div class="included-icon">
              <i class="uil uil-bed text-main-color"></i>
              <i class="uil uil-ruler-combined text-main-color"></i>
              <i class="uil uil-bath text-main-color"></i>
              <i class="uil uil-keyhole-circle text-main-color"></i>
              <i class="uil uil-streering text-main-color"></i>
              <i class="uil uil-shovel text-main-color"></i>
            </div>
            <div class="included-text">
              <p>{{  $single_property->property_bed }} Bed</p>
              <p>{{  $single_property->property_area }} sqft</p>
              <p>{{  $single_property->property_bath }} Bath</p>
              <p>{{  $single_property->property_rooms }} Rooms</p>
              <p>{{  $single_property->property_garages }} Garages</p>
              <p>{{   Str::limit($single_property->property_year_built, 4, '') }} </p>
            </div>
            
          </div>

          <div class="listing-single-gallery" id="listing-single-gallery">

            <a class="cwa-lightbox-image image-grid-col image-grid-row" href="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['featured_img'] }}" data-desc="Featured Image">
              <img class="" src="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['featured_img'] }}" alt="" >
            </a>

            
            <a class="cwa-lightbox-image image-grid-size" href="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img1'] }}" data-desc="Gallery Image1">
              <img src="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img1'] }}" alt="">
            </a>

            <a class="cwa-lightbox-image image-grid-size" href="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img2'] }}" data-desc="Gallery Image2">
              <img src="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img2'] }}" alt="">
            </a>

            <a class="cwa-lightbox-image image-grid-size" href="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img3'] }}" data-desc="Gallery Image3">
              <img src="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img3'] }}" alt="">
            </a>

            <a class="cwa-lightbox-image image-grid-size" href="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img4'] }}" data-desc="Gallery Image4">
              <img src="{{ URL('uploads/new_property'). '/' .$single_property['property_gallery']['gallery_img4'] }}" alt="">
            </a>
          
          </div>
        </div>
      </div>
      <div class="container">

        @auth
        @if($single_property->user_id != auth()->user()->id && $single_property->is_sold == 0)
        <div class="get-in-touch-with-seller">
          <form action="" class="get-in-touch-with-seller-form">
            <div class="input-wrapper">
              <span><i class="fa-solid fa-user"></i></span>
              <input type="text" placeholder="Your Name" class="property-input" value="@isset(auth()->user()->name) {{ auth()->user()->name }} @endisset">
            </div>
            <div class="input-wrapper">
              <span><i class="fa-solid fa-envelope"></i></span>
              <input type="text" placeholder="Email Address" class="property-input" value="@isset(auth()->user()->email) {{ auth()->user()->email }} @endisset">
            </div>
            <div class="input-wrapper your-phone">
              <span><i class="fa-solid fa-phone"></i></span>
              <input type="text" placeholder="Your Phone" class="property-input" value="@isset(auth()->user()->contact_no) {{ auth()->user()->contact_no }} @endisset" >
            </div>
            <div>
              <button type="submit" class="contact_seller" name="contact_seller">Contact Host</button>
              <input type="hidden" value="{{ $single_property->user->email }}" class="contact_seller_email" name="contact_seller_email">
            </div>
          </form>
        </div>
        @endif
        @endauth

        <ul class="details-list">
          <li><i class="fa-solid fa-house"></i>Entire Home
            <span>You will have the entire flat for you.</span>
          </li>
          <li><i class="fa-solid fa-paintbrush"></i>Enhanced Clean
            <span>This owner has commited to {{ config('app.name') }}'s cleaning process</span>
          </li>
          <li><i class="fa-solid fa-location-dot"></i>Great Location
            <span>90% of recent owner gave the location a 5 star rating</span>
          </li>
          <li><i class="fa-solid fa-heart"></i>Great viewing Experience
            <span>100% of recent guests gave the location a 5 star rating</span>
          </li>
        </ul>

        <hr class="line">

        <div class="description">
          <h3>{{ $single_property['property_name'] }}</h3>
          <p class="home-desc">
            {{ $single_property['property_desc'] }}
          </p>
        </div>
        
        <hr class="line">
        
        <div class="map">
          <h2>Location</h2>
          
          <div class="list-location">
            <p>Country: <span> Phillipines</span></p>
            <p>Province: <span>{{ $single_property->location['provinces'] }}</span></p>
            <p>City: <span>{{ $single_property->location['cities'] }}</span></p>
            <p>Barangay: <span>{{ $single_property->location['barangays'] }}</span></p>
            <p>Zip/Postal Code: <span>{{ $single_property->location['postal_code'] }}</span></p>
            <p>Address: <span>{{ $single_property->location['street_address'] }}</span></p>
          </div>

          <h3>It's like a home away from home.</h3>
        </div>

        


        @if($single_property->property_floors != 0)
        <hr class="line">
        <div class="floor-plans">
          <h2>Floor Plans</h2>
          <div id="accordion">
             <!-- Accordion -->
            <div id="accordionExample" class="accordion shadow">

              @if($single_property->property_floor_img['floor_plan1'] != null )
              <!-- Accordion item 1 -->
              <div class="card">
                <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                  <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Floor Plan1</a></h6>
                </div>
                <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
                  <div class="card-body">
                    <a href="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan1'] }}" class="cwa-lightbox-image" data-desc="Floor Plan1">

                      <img src="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan1'] }}" alt="">
                    </a>
                  </div>
                </div>
              </div>
              @endif

              @if($single_property->property_floor_img['floor_plan2'] != null )
               <!-- Accordion item 2 -->
               <div class="card">
                <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                  <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Floor Plan3</a></h6>
                </div>
                <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
                  <div class="card-body">
                    <a href="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan2'] }}" class="cwa-lightbox-image" data-desc="Floor Plan2">

                      <img src="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan2'] }}" alt="">
                    </a>
                  </div>
                </div>
              </div>
              @endif

              @if($single_property->property_floor_img['floor_plan3'] != null )
               <!-- Accordion item 3 -->
              <div class="card">
                <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                  <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Floor Plan3</a></h6>
                </div>
                <div id="collapseThree" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
                  <div class="card-body">
                    <a href="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan3'] }}" class="cwa-lightbox-image" data-desc="Floor Plan3">

                      <img src="{{ URL('uploads/new_property'). '/' .$single_property->property_floor_img['floor_plan3'] }}" alt="">
                    </a>
                  </div>
                </div>
              </div>
              @endif
  
            </div>
          </div>
        </div>
        @endif

        <hr class="line">

        
        <div class="amenities">
          <h2>Offices Amenities</h2>
          <ul class="amenities-kit">
            
            @if( $single_property->amenities['aircon'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Air conditioning</li> 
            @endif

            @if( $single_property->amenities['emergency_exit'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Emergency Exit</li>
            @endif

            @if( $single_property->amenities['fully_furnished'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Furnished offices</li>
            @endif

            @if( $single_property->amenities['semi_furnished'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Furnished offices</li>
            @endif

            @if( $single_property->amenities['gym'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Gym</li>
            @endif

            @if( $single_property->amenities['kitchen'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Kitchen</li>
            @endif

            @if( $single_property->amenities['laundry'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Laundry Room</li>
            @endif

            @if( $single_property->amenities['lawn'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Lawn</li>
            @endif

            @if( $single_property->amenities['meeting_rooms'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Meeting rooms</li>
            @endif

            @if( $single_property->amenities['onsite_parking'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;On-Site Parking</li>
            @endif

            @if( $single_property->amenities['shared_internet'] != 0)
            <li><img src="{{ URL('storage/check.png') }}" alt="">&nbsp;Shared Internet</li>
           @endif

          </ul>
        </div>

        <hr class="line">

        <div class="hosted-by mb-2">
          
          <div class="hosted-by-avatar-img">
            @if($single_property->user->images != null)
            <img src="{{ URL('uploads/profile_pic'). '/' .$single_property->user->images }}" alt="">
            @else
            <img src="{{ URL('uploads/profile_pic/businessman.png') }}" alt="?">
          </div>
         
          @endif
          <div>
            <h2>
              Posted by <span class="text-main-color">     
                @guest
                {{ $single_property->user->name }}
                @endguest

                @auth
                @if($single_property->user->name == auth()->user()->name)  
                You
                @else 
                {{ $single_property->user->name }}
                @endif
                @endauth
                
                </span>
            </h2>
            <p>Response rate: {{ $single_property->user->response_rate }}% &nbsp; &nbsp; Response time: {{ $single_property->user->response_time }}min</p>
            @auth
            @if($single_property->user_id != auth()->user()->id && $single_property->is_sold == 0)
            <a href="javascript:void(0)" class="contact-host">Contact Host</a>
            @endif
            @endauth
          </div>
        </div>
        
      </div>
      
    </section>
    @endif
    @include('partials.footer')
@endsection
@push('scripts')
<script>
$(document).ready(function() { 
  let contact_seller;
  $('.contact_seller').click(function(e) {
      e.preventDefault();
      let fd = new FormData();
      fd.append('email', $('.contact_seller_email').val());
      fd.append('_token', '{{ csrf_token() }}');

      $.ajax({
          url: "{{ route('auth.contactSeller') }}",
          method: 'post',
          data: fd,
          cache: false,
          processData: false,
          contentType: false,
          beforeSend: function(res) {
            contact_seller = bootbox.dialog({
                      message: `<div class="text-center"><i class="fas fa-spin
                      fa-spinner"></i> Loading...</div>`,
                      closeButton: false
              });
          },
          dataType: 'json',
          success: function(res) {

            console.log(res)

              if(res.status == 200) {

                  $('.contact_seller').prop('disabled',true);
                  $('.contact_seller').addClass('not-allowed');
                  contact_seller.modal('hide');
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
});
</script>

@endpush
   