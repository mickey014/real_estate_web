@section('title', 'Team')
@extends('layouts.app')


@section('content')

<header id="home" class="home">
    <x-navbar />
</header>

<section class="swiper mySwiper" id="our-team">

    <div class="swiper-wrapper">

      <div class="card swiper-slide">
        <div class="card__image">
          <img src="{{ url('storage/mayee.jpg') }}" alt="card image">
        </div>

        <div class="card__content">
          <span class="card__title">Head team</span>
          <span class="card__name">Mayee Solijon Cruz</span>
          <p class="card__text">Don’t take yourself too seriously. Know when to laugh at yourself, and find a way to laugh at obstacles that inevitably present themselves.</p>
        </div>
      </div>

      <div class="card swiper-slide">
        <div class="card__image">
          <img src="{{ url('storage/kirk.jpg') }}" alt="card image">
        </div>

        <div class="card__content">
          <span class="card__title">Programmer</span>
          <span class="card__name">Kirk Anthony Mendoza</span>
          <p class="card__text">The most important thing is to enjoy your life to be happy it's all that matters.</p>
        </div>
      </div>

      <div class="card swiper-slide">
        <div class="card__image">
          <img src="{{ url('storage/ronn.jpg') }}" alt="card image">
        </div>

        <div class="card__content">
          <span class="card__title">Web Developer</span>
          <span class="card__name">Ronald Aguilar Gardoce</span>
          <p class="card__text">When you have a dream, you've got to grab it and never let go.</p>
        </div>
      </div>

      <div class="card swiper-slide">
        <div class="card__image">
          <img src="{{ url('storage/earl.jpg') }}" alt="card image">
        </div>

        <div class="card__content">
          <span class="card__title">Web Designer</span>
          <span class="card__name">Earl Junicel Guardiana</span>
          <p class="card__text">You can be everything. You can be the infinite amount of things that people are.</p>
        </div>
      </div>
      
      <div class="card swiper-slide">
        <div class="card__image">
          <img src="{{ url('storage/james.jpg') }}" alt="card image">
        </div>

        <div class="card__content">
          <span class="card__title">Mobile App Developer</span>
          <span class="card__name">James Tirariray</span>
          <p class="card__text">Find out who you are and be that person. That’s what your soul was put on this earth to be. Find the truth, live that truth, and everything else will come.</p>
        </div>
      </div>

    </div>
  </section>

@include('partials.footer')
    
@endsection