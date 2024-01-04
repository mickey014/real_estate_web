<footer id="contact">
    <div class="container">
      {{-- <div class="row footer-top">
        <div class="col-12 col-md-6">
          <!-- logo -->
          <h3>luxestate</h3>
          <h3>Explore Real Estate</h3>
        </div>
        <div class="col-12 col-md-6 Newsletter">
          <input type="text" placeholder="Subscribe To Our Newsletter" class="left">
          <button class="newsletter-btn left"></button>
        </div>
      </div> --}}
      <div class="row footer-bottom">
        <div class="col-sm-12 col-md-4 footer-logo">
          <h4>{{ config('app.name') }}</h4>
          <p>© {{ date("Y") }} - {{ config('app.name') }},<br>All Right Reserved</p>
        </div>
        <div class="col-sm-3 col-md-2 footer-column">
          <h5>Quick Links</h5>
          <a href="#">About</a>
          <a href="#">Team</a>
          <a href="#">Services</a>
          <a href="#">Contact Us</a>
        </div>          
        <div class="col-sm-3 col-md-2 footer-column">
          <h5>PRODUCT</h5>
          @forelse ($property_types as $type)
          <a href="javascript:;">{{ $type->name }}</a>
          @empty
            ?
          @endforelse
          
        </div>
        <div class="col-sm-3 col-md-2 footer-column">
          <h5>SERVICES</h5>
          <a href="{{ URL('/rent') }}">Renting</a>
          <a href="{{ URL('/buy') }}">Selling</a>
          
        </div>
      </div>
    </div>
</footer>