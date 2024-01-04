@section('title', 'Services')
@extends('layouts.app')

@section('content')

<header id="home" class="home">
    <x-navbar />
</header>

<section class="our-services">
    
      <h2 class="section-heading">Our Services</h2>
    
    <div class="row">
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-calendar-check"></i>
          </div>
          <h3>Appointment</h3>
          <p>
            a salesperson who works for a real estate agency.
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-handshake"></i>
          </div>
          <h3>Buy and Sell</h3>
          <p>
             document that tells a potential client how much your product or service will cost
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-key"></i>
          </div>
          <h3>Renting</h3>
          <p>
            property used or occupied by any tenant for which rent is paid to a landlord.
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h3>Marketing</h3>
          <p>
            We are the brilliants in terms of digital marketing
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-handshake-simple"></i>
          </div>
          <h3>Support</h3>
          <p>
            Our culture is built around meeting customer needs.
          </p>
        </div>
      </div>
      <div class="column">
        <div class="card">
          <div class="icon-wrapper">
            <i class="fa-solid fa-chart-pie"></i>
          </div>
          <h3>Data Analysis</h3>
          <p>
            Unlock the secrets of your business with data analytics.
          </p>
        </div>
      </div>
    </div>
    
  </section>
  @include('partials.footer')


    
@endsection