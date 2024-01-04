
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="images/favicon.png" />
    
     <!-- Icon Font Stylesheet -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
     <link href="
https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css
" rel="stylesheet">
<!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/cwa_lightbox_css.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/mobile-view.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.css" rel="stylesheet"/>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>@yield('title')</title>
</head>
<body>

    
    <main>
        @yield('content')


        
    </main>


    <!-- Scripts -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/cwa_lightbox_v1.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/wow.min.js') }}" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.1/toastr.min.js" defer></script>
  <script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
  <script type="text/javascript">
    $(function(){
  
       // Spinner
       var spinner = function () {
          setTimeout(function () {
              if ($('#spinner').length > 0) {
                  $('#spinner').removeClass('show');
              }
          }, 1);
      };
      spinner();
      
      // Initiate the wowjs
      new WOW().init();

      

      
      $('.contact-host').click(function() {
        $('html, body').animate({
          scrollTop: 1200
        }, 500);

        return false;
      });
      
  
      $('[data-toggle="tooltip"]').tooltip()
      toastr.options = {
          preventDuplicates: true,
          preventOpenDuplicates: true,
          "positionClass": "toast-bottom-right",
          'newestOnTop': 'true',
          'timeOut': '1500',
      };

      var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
          rotate: 0,
          stretch: 0,
          depth: 300,
          modifier: 1,
          slideShadows: false,
        },
        pagination: {
          el: ".swiper-pagination",
        },
      });

      var path = "{{ route('autocomplete') }}";
      $('.search-property-input').typeahead({
        source:function(query, process) {
          return $.get(path,{query:query},function(data) {
            // console.log(data)
            return process(data);
          });
        }
      }); 

      $('.search_by').submit(function(e) {
        
        var location = $(document).find('.search-property-input');
        
        if (location.val() !== "" ) {
          location.attr('name', 'location');
          
        } 

      });


    });
  </script>

  
  @stack('scripts')
    
</body>
</html>