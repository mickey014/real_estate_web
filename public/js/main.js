$(document).ready(function () {
  /* Check width on page load*/
  // if ($(window).width() < 993) {
  //   $('.menu-button').addClass('hide'); 
  // }
  if ($(document).width() <= 420) {
    $(".join-us-link").click(function () {
      $('.left-box').remove();
    });

    $('#appartments').remove();
    $('#search-section .search_by').addClass('d-none')
    $('#add-listing-btn').remove()

    // alert(5)

    $('.fa-magnifying-glass').click(function() {
      $('.search_by').toggleClass('d-none')
    })

  }

  $('#signup-tab').click(function() {
    $('#login-tab').removeClass('active')
  })

  $('#login-tab').click(function() {
    $('#signup-tab').removeClass('active')
  })
});

// $(window).resize(function () {
//   /*If browser resized, check width again */
//   if ($(window).width() < 390) {
//     // $(".join-us-link").click(function () {
//     //   $('.left-box').remove();
//     // });
//     alert(5)
//   }
//   else { 
//     // $('.menu-button').addClass('hide'); 
//   }
// });

$(function () {
  var hasBeenTrigged = false;
  $(window).scroll(function () {
    if ($(this).scrollTop() >= 100 && !hasBeenTrigged) { // if scroll is greater/equal then 100 and hasBeenTrigged is set to false.
      $('.navs').addClass('small-nav'); 
      hasBeenTrigged = true;
    } else if ($(this).scrollTop() <= 100 && hasBeenTrigged) {
      $('.navs').removeClass('small-nav');
      hasBeenTrigged = false;
    }
  });
});
//Toogle Mobile Menu
$(".menu-button").click(function () {
  $('.menu').toggleClass('slide');
});


