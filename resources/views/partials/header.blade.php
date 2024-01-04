<!------------------------------------------------ HEADER SECTION -->
<header id="home" class="home">
  
  <x-navbar/>
  {{-- Hero Page --}}
  <div class="hero">
    <div class="container-fluid p-0">
      <div class="hero-wrapper">
        <div class="title p-4 wow fadeIn" data-wow-delay="0.1s">
          <!-- Hero Title -->
          <h1 class="hero-h1">Find A <span class="text-main-color">Perfect Home</span> To Live With Your Family</h1>
          <p class="mt-4">With a robust selection of popular properties on hand, as well <br/>as leading properties from real estate experts.</p>
            <!-- Search -->
            {{-- <form action="">
              <input class="left" type="text" placeholder="Search Location">
              <button type="submit" class="search-btn left">Search</button>
            </form> --}}
            <a href="buy" class="btn get-started py-3 px-5 animated fadeIn">Get Started</a> 
        </div>
        <div class="hero-image wow fadeIn" style="background-image: url({{ URL('storage/hero-img.jpg') }});" data-wow-delay="0.1s">
        </div>
         <!-- Search Start -->
    <div class="container-fluid home-search-property flex-center wow fadeIn" data-wow-delay="0.1s">
      <div class="container">
          <form method="GET" action="{{ route('search') }}" class="search_by row g-2" role="search">
             
              <div class="col-md-3">
                  
                  <select class="form-select border-0 p-3 w-100" name="status">
                    <option value="buy">Buy</option>
                    <option value="rent">Rent</option>
                </select>
              </div>
              <div class="col-md-3">
                  <select class="form-select border-0 p-3 w-100" name="type">
                      <option selected value="all">Any</option>
                      @forelse ($property_types as $type)
                      <option value="{{  Str::lower($type['name']) }}">{{$type['name'] }}</option>
                      @empty
                        ?
                      @endforelse
                  </select>
              </div>
              <div class="col-md-4">
                <input type="text" class="typeahead form-control border-0 search-property-input" placeholder="Location">
              </div>
                
              <div class="col-md-2">
                  <button type="submit" class="btn btn-search-property w-100">Search</button>
              </div>
          </form>
      </div>
  </div>
<!-- Search End -->
      </div>
    </div>
  </div>
  
</header>

