<?php
$error_number = 404; 
?>
@section('title', '404 Page not found.')
@extends('layouts.app')


  @section('content')

  <header id="home" class="home">
    <x-navbar />
  </header>

  <section class="page_404">
    <div class="container">
      
      <div class="text-center">
        <h1 class="mb-0">500</h1>
        <h2 class="mb-0">Internal Server Error.</h2>
        <div class="four_zero_four_bg">
        </div>

        <div class="contant_box_404">
          <h3>
            Look like you're lost
          </h3>

          <p>the page you are looking for is not avaible!</p>

          <a href="/" class="link_404">Go to Home</a>
        </div>
          
      </div>
    </div>
  </section>

  
    
@endsection