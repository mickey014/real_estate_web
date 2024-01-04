<?php 
// $status = isset($_GET['status']) ? $_GET['status'] : '';
// $prop_type = isset($_GET['type']) ? $_GET['type'] : '';


// $buy_status = ($status == 'buy') ? 'selected' : '';
// $rent_status = ($status == 'rent') ? 'selected' : '';
// $all_prop_types =  ($prop_type == 'all') ? 'selected' : '';
// $location = isset($_GET['location']) ? $_GET['location'] : '';
?>
@section('title', 'Buy')
@extends('layouts.app')


  @section('content')
    
    <header id="home" class="home">
        <x-navbar />
    </header>

    <section class="page-header" style="background:url({{ URL('storage/page-header.jpg') }})">
      <div class="header-wrapper container">
        <h2>Property Lists</h2>
        <ul>
          <li><a href="/">Home</a></li>
          <li>></li>
          <li><a href="{{ URL('buy') }}" class="active-page">Buy</a></li>
        </ul>  
      </div>
    </section>

    <section id="search-section">
      <form method="GET" action="{{ route('search') }}" class="search_by row g-2" role="search">
              
              <div class="col-md-3">
                  
                  <select class="form-select border-0 p-3 w-100" name="status">
                    <option value="buy">Buy</option>
                    <option value="rent">Rent</option>
                </select>
              </div>
              <div class="col-md-3">
                  <select class="form-select border-0 p-3 w-100" name="type">
                      <option value="all">Any</option>
                      @forelse ($property_types as $type)
                      <option value="{{  Str::lower($type['name']) }}">
                        {{$type['name'] }}
                      </option>
                      @empty
                        ?
                      @endforelse
                  </select>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control search-property-input" placeholder="Location">
              </div>
                
              <div class="col-md-2">
                  <button type="submit" class="btn btn-search-property w-100">Search</button>
              </div>
          </form>
    </section>

    <section id="show-search">
      <i class="fa-solid fa-magnifying-glass"></i>
    </section>

    <section id="listing-page-container">
        <div class="container">
          <div class="row"> 
            <div class="col-md-8 left-col">
                
                
                @forelse ($property as $prop)
                <div class="house">
                    <div class="house-img" style="background-image: url({{ URL('uploads/new_property'). '/' .$prop['property_gallery']['featured_img'] }});">
                        
                        @if($prop->is_featured == 1)
                          <div class="property-featured">Featured</div>
                        @endif
                        <div class="property-for-sell">{{ $prop->property_status}} </div>
                        <div class="listing-property-user">
                        @if($prop->user->images != null)
                          <img class="listing-property-user-img" src="{{ URL('uploads/profile_pic'). '/' .$prop->user->images }}">
                        @else
                          <img class="listing-property-user-img" src="{{ URL('uploads/profile_pic/businessman.png') }}" alt="?">
                        @endif
                        </div>

                        @if($prop->is_sold == 1)
                        <img src="{{ URL('storage/out-of-stock.png') }}" alt="" class="sold-out">
                        @endif
                    </div>
                    <div class="house-info">
                        <h3>{{ $prop->location['street_address'] }}</h3>

                        <div class="price">
                          @if($prop['property_status'] == 'rent')
                            <small class="previous-price">₱{{ $prop->property_before_price  }}/mo</small>
                            <p class="listing-price-monthly">₱{{ $prop->property_after_price  }}/mo</p>
                          @else
                          <small class="previous-price">₱{{ $prop->property_before_price  }}</small>
                          <p class="listing-price-monthly">₱{{ $prop->property_after_price  }}</p>
                          @endif
                        </div>
                        
                        <a href="{{ url('/buy').'/'.$prop->property_name_slug}}" class="listing-price-view" data-toggle="tooltip" data-placement="top" title="Quick View!">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>

                    <div class="house-info2">
                      <p><i class="uil uil-bed mr-1"></i>{{ $prop->property_bed  }} Bed</p>
                      <p><i class="uil uil-ruler-combined"></i>{{ $prop->property_size  }} sqft</p>
                      <p><i class="uil uil-bath"></i>{{ $prop->property_bath  }} Bath</p>
                      {{-- <p><i class="uil uil-keyhole-circle"></i>{{ $prop->property_rooms  }} Rooms</p> --}}
                      <p><i class="uil uil-shovel"></i>{{ Str::limit($prop->property_year_built, 4, '')  }} Year Built</p>
                    </div>
                </div>
                @empty
                  <h2 class="result">No Property Listed!</h2>
                @endforelse
                


        </div>
        <div class="col-md-4 right-col">
          <div class="sidebar">

            <h2>Featured Property</h2>
            <hr class="line1">
            <hr class="line2">

            @forelse ($featured_prop as $f)
            <div class="sidebar-featured-prop">
              @if($f->property_status == "rent")
              <a href="{{ url('/rent').'/'.$f->property_name_slug }}">
                <img src="{{ URL('uploads/new_property'). '/' .$f->property_gallery['featured_img'] }}" alt="">
              </a>
              @else
              <a href="{{ url('/buy').'/'.$f->property_name_slug }}">
                <img src="{{ URL('uploads/new_property'). '/' .$f->property_gallery['featured_img'] }}" alt="">
              </a>
              @endif
              <div class="featured-prop-wrapper">
                <h3>{{ $f->property_type }}</h3>
                <p>
                  <i class="uil uil-map-marker-alt"></i> {{ Str::limit($f->location['street_address'], 45, '...') }}
                </p>
              </div>
            </div>
            @empty
                ?
            @endforelse


            <h2 class="recently-added-h2">For Rent Property</h2>
            <hr class="line1">
            <hr class="line2">

            @forelse($rent_property_sidebar as $rent_sidebar)
              <div class="sidebar-featured-prop">
                <a href="{{ url('/rent').'/'.$rent_sidebar->property_name_slug }}">
                  <img src="{{ URL('uploads/new_property'). '/' .$rent_sidebar->property_gallery['featured_img'] }}" alt="">
                </a>
                <div class="featured-prop-wrapper">
                  <h3>{{ $rent_sidebar->property_type }}</h3>
                  <p>
                    <i class="uil uil-map-marker-alt"></i> {{ Str::limit($rent_sidebar->location['street_address'], 45, '...') }}
                  </p>
                </div>
              </div>

            @empty
              ?
            @endforelse

          </div>
        </div>                                          
        </div>

        <div class="row">
          <div class="col-5">
            <p class="font-weight-bold">Page {{$property->currentPage()}} - {{$property->lastPage()}} of {{$property->lastPage()}}
            </p>
            
          </div>
          <div class="col-7 pagination-wrapper">
              {{ $property->onEachSide(1)->links() }}      
          </div>
        </div>
      </div>
    </section>

  @include('partials.footer')
    
@endsection

   