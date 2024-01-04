
@section('title', 'Home')
@extends('layouts.app')


  @section('content')
    @include('partials.header')

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
          <span class="sr-only">Loading...</span>
      </div>
    </div>

     <!-- Property List Start -->
    <section class="container-xxl" id="listing-property">
      <div class="container">
          <div class="row g-0 gx-5 align-items-end">
              <div class="col-lg-6">
                  <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                      <h1 class="mb-3">Property Listing</h1>
                      <p>Glean wisdom from these four noteworthy listing description examples from expert real estate agents and let the inspiration begin.</p>
                  </div>
              </div>
          </div>
              <div class="p-0">
                  <div class="row g-4">
                      @forelse ($property_listing as $list)
                      <div class="col-lg-4 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s" >
                        <div class="property-item rounded overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                @php
                                  $status = ($list->property_status == 'rent') ? 'rent/' : 'buy/';
                                @endphp
                                <a href="{{$status. $list->property_name_slug}}" class="">
                                  <img class="img-fluid" src="{{ URL('uploads/new_property'). '/' .$list['property_gallery']['featured_img'] }}" alt="?">
                                  @if($list->is_featured == 1)
                                  <div class="property-featured">Featured</div>
                                  @endif
                                  @if($list->property_status == "rent")
                                  <div class="property-for-sell">Rent</div>
                                  @else
                                  <div class="property-for-sell">Sell</div>
                                  @endif
                                  <div class="rounded-top property-types">{{ $list->property_type }}</div>
                                </a>
                                
                            </div>
                            <div class="px-3 pt-3 pb-0 property-item-info">
                                @if($list->property_status == "rent")
                                <h5 class="property-monthly-price">₱{{ $list->property_after_price }} <small>/mo</small></h5>
                                @else
                                <h5 class="property-monthly-price">₱{{ $list->property_after_price }}</h5>
                                @endif
                                <a class="d-block h5 property-title" href="{{ $status. $list->property_name_slug}}">
                                  {{Str::limit($list->property_name, 22, '...')}}
                                </a>
                                <p>
                                  <i class="fa fa-map-marker-alt mr-2 text-main-color"></i>
                                  @php 
                                    $location = $list->location['provinces']. ', ' .$list->location['cities']. ', ' .$list->location['barangays']; 
                                  @endphp

                                  {{ Str::limit($location, 60, '...') }} 
                                </p>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-main-color mr-2"></i>{{ $list->property_size}} Sqft</small>
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-main-color mr-2"></i>{{ $list->property_bed}} Bed</small>
                                <small class="flex-fill text-center py-2"><i class="fa fa-bath text-main-color mr-2"></i>{{ $list->property_bath}} Bath</small>
                            </div>
                        </div>
                      </div>
                      @empty
                        ?
                      @endforelse
                      

                      <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <a class="btn btn-browse-more-prop py-3 px-5" href="{{ URL('/buy') }}">Browse More Property</a>
                      </div>
                </div>
              </div>
      </div>
    </section>
  <!-- Property List End -->
   
    <!------------------------------------------------ STATISTIC SECTION -->
    <section class="statistic" id="about">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-6 wow slideInLeft" data-wow-delay="0.1s">
            <h3>Our’s Company<br>Statistics</h3>
            <p>The sales department serves to be one of the most crucial units of an organisation. The sales unit tends to develop the necessary resources and financial assets that are required to run a business. The process of selling a good or service to a customer typically involves exchanging a commodity for money or any other valuable asset. </p>
            <p>he process of sales can be broadly classified into a number of categories, namely, inside sales, outside sales, agency sales, B2B sales, B2C sales, etc. The strategies and methodologies for selling goods to the target audience are closely monitored by the analysts and are required to be selected with high accuracy levels and precision. </p>
          </div>
          <div class="col-12 col-lg-6 statistic-wrapper wow slideInRight" data-wow-delay="0.1s">
            <div class="statistic-box text-center">
              <p class="text-main-color">{{ $users->count() }}</p>
              <p class="text-main-color">Clients</p>
            </div>
            <div class="statistic-box text-center">
              <p class="text-main-color">{{ $apartments->count() }}</p>
              <p class="text-main-color">Appartments</p>
            </div>
            <div class="statistic-box text-center">
              <p class="text-main-color">14</p>
              <p class="text-main-color">Visitor</p>
            </div>
            <div class="statistic-box text-center">
              <p class="text-main-color">{{ $agent->count() }}</p>
              <p class="text-main-color">Employees</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!------------------------------------------------ APPARTMENTS SECTION -->
    <section id="appartments" class="appartments py-5">
      <div class="container">
        <div class="row">
          <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
            <h2>There are <span class="text-main-color">{{ $apartments->count() }}</span> <br>Appartments For Rent</h2>
          </div>
        </div>
          <!-- Appartment  -->
          
          
          <div class="row">
            @forelse ($apartments as $apartment)
            <div class="col-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
              <div class="appartment-box">
                <div class="appartment-image">
                  <!-- Appartment Image  -->
                  <img src="{{ URL('uploads/new_property'). '/' .$apartment->property_gallery['featured_img'] }}" alt="">
                </div>
                <div class="appartment-info">
                  <div class="appartment-title">
                    <!-- Appartment Address  -->
                    <p>{{ Str::limit($apartment->location['street_address'], 38, '...')  }}</p>
                  </div>
                  <div class="appartment-details">
                    <div class="price left">
                      <!-- Appartment Price  -->
                      <p>₱{{ $apartment->property_after_price }}</p>
                    </div>
                    <div class="bedrooms right flex-center">
                      <img src="images/bed.svg" class="left" alt="">
                      <!-- Appartment Number Of Bedrooms  -->
                      <p class="left"><i class="fa fa-bath text-main-color"></i>&nbsp;{{ $apartment->property_bath }} BA</p>
                    </div>
                    <div class="bathrooms right flex-center">
                      <img src="images/shower.svg" class="left" alt="">
                      <!-- Appartment Number of Bathrooms  -->
                      
                      <p class="left"><i class="fa fa-bed text-main-color"></i>&nbsp;{{ $apartment->property_bed }} BD</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @empty
            <h1>There are no Apartment Listed</h1>
            @endforelse
          </div>
          
       
        <div class="row">
          <div class="col-12">
            <div class="lux-shadow search-appartments search">
              <!-- Search -->
              <form method="GET" action="{{ route('search') }}" role="search" id="search_by_apartment_location">
                
                <input type="hidden" name="status" value="rent">
                <input type="hidden" name="type" value="apartments">
                <input class="left apartment_location" type="text" placeholder="Search Location">
                <button type="submit" class="search-btn left">Search</button>
              </form>
              
            </div>
            <div class="search-all">
              <form method="GET" action="{{ route('search') }}" role="search" id="search_by_apartment">
                <input type="hidden" name="status" value="rent">
                <input type="hidden" name="type" value="apartments">
                <button class="search-btn left search-all-btn text-dark">View All Apartments</button>
              </form>
            </div>
          </div>
        </div>

        
      </div>
    </section>
    

    <!-- Team Start -->
    <section class="container-xxl" id="property-agent">
      <div class="container">
          <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
              <h1 class="mb-3">Property Agents</h1>
              <p>Has expert knowledge in the buying, selling, renting, leasing and managing of real estate. They typically research real estate markets, identify market trends, advise clients, prepare property listings and negotiate property sales.</p>
          </div>
          <div class="row g-4">
              <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                  <div class="team-item rounded overflow-hidden">
                      <div class="position-relative">
                          <img src="{{ URL('storage/james.jpg') }}" style="height: 250px; width:100%;">
                          <div class="property-agent-social-media">
                              <a class="btn btn-social-media" href=""><i class="fab fa-facebook-f"></i></a>
                              <a class="btn btn-social-media" href=""><i class="fab fa-twitter"></i></a>
                              <a class="btn btn-social-media" href=""><i class="fab fa-instagram"></i></a>
                          </div>
                      </div>
                      <div class="text-center p-4 mt-3">
                          <h5 class="font-weight-bold text-dark-color text-md" style="font-size:1.2rem;">James Tirariray</h5>
                          <small>IT Department</small>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                  <div class="team-item rounded overflow-hidden">
                    <div class="position-relative">
                      <img src="{{ URL('storage/mayee.jpg') }}" style="height: 250px; width:100%;">
                      <div class="property-agent-social-media">
                          <a class="btn btn-social-media" href=""><i class="fab fa-facebook-f"></i></a>
                          <a class="btn btn-social-media" href=""><i class="fab fa-twitter"></i></a>
                          <a class="btn btn-social-media" href=""><i class="fab fa-instagram"></i></a>
                      </div>
                  </div>
                  <div class="text-center p-4 mt-3">
                      <h5 class="font-weight-bold text-dark-color text-md" style="font-size:1.2rem;">Mayee Cruz</h5>
                      <small>IT Department</small>
                  </div>
                  </div>
              </div>
              <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item rounded overflow-hidden">
                  <div class="position-relative">
                    <img src="{{ URL('storage/ronn.jpg') }}" style="height: 250px; width:100%;">
                    <div class="property-agent-social-media">
                        <a class="btn btn-social-media" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-social-media" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-social-media" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="text-center p-4 mt-3">
                    <h5 class="font-weight-bold text-dark-color text-md" style="font-size:1.2rem;">Ronn Aguilar</h5>
                    <small>IT Department</small>
                </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="team-item rounded overflow-hidden">
                  <div class="position-relative">
                    <img src="{{ URL('storage/earl.jpg') }}" style="height: 250px; width:100%;">
                    <div class="property-agent-social-media">
                        <a class="btn btn-social-media"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-social-media" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-social-media" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="text-center p-4 mt-3">
                    <h5 class="font-weight-bold text-dark-color text-md" style="font-size:1.2rem;">Earl Guardiana</h5>
                    <small>IT Department</small>
                </div>
                </div>
              </div>
          </div>
      </div>
  </section>

  @include('partials.footer')

@endsection
@push('scripts')
<script>
  var path = "{{ route('apartment.autocomplete') }}";


  $('.apartment_location').typeahead({
    source:function(query, process) {
      
      return $.get(path,{query:query},function(data) {
        return process(data);
      });
    }
  }); 
  
  $('#search_by_apartment_location').submit(function(e) {

    var apartment_loc = $(document).find('.apartment_location');

    if(apartment_loc.val() !== "") {
      apartment_loc.attr('name', 'location');
    } else {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "I'm Afraid you didn't input location.",
      })
    }

    
  });
  
</script>
@endpush