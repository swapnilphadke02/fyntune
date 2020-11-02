/**
* Template Name: Reveal - v2.1.0
* Template URL: https://bootstrapmade.com/reveal-bootstrap-corporate-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

var base_url="http://localhost/fyntune";
!(function($) {
  "use strict";

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });
  $('.back-to-top').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 1500, 'easeInOutExpo');
    return false;
  });

  // Stick the header at top on scroll
  $("#header").sticky({
    topSpacing: 0,
    zIndex: '50'
  });

  // Intro background carousel
  $("#intro-carousel").owlCarousel({
    autoplay: true,
    dots: false,
    loop: true,
    animateOut: 'fadeOut',
    items: 1
  });


  // Mobile Navigation
  if ($('#nav-menu-container').length) {
    var $mobile_nav = $('#nav-menu-container').clone().prop({
      id: 'mobile-nav'
    });
    $mobile_nav.find('> ul').attr({
      'class': '',
      'id': ''
    });
    $('body').append($mobile_nav);
    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

    $(document).on('click', '.menu-has-children i', function(e) {
      $(this).next().toggleClass('menu-item-active');
      $(this).nextAll('ul').eq(0).slideToggle();
      $(this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });
  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  // Smooth scroll for the navigation menu and links with .scrollto classes
  var scrolltoOffset = $('#header').outerHeight() - 1;
  $(document).on('click', '.nav-menu a, #mobile-nav a, .scrollto', function(e) {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (target.length) {
        e.preventDefault();

        var scrollto = target.offset().top - scrolltoOffset;

        $('html, body').animate({
          scrollTop: scrollto
        }, 1500, 'easeInOutExpo');

        if ($(this).parents('.nav-menu').length) {
          $('.nav-menu .menu-active').removeClass('menu-active');
          $(this).closest('li').addClass('menu-active');
        }

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
        return false;
      }
    }
  });

  // Activate smooth scroll on page load with hash links in the url
  $(document).ready(function() {
    if (window.location.hash) {
      var initial_nav = window.location.hash;
      if ($(initial_nav).length) {
        var scrollto = $(initial_nav).offset().top - scrolltoOffset;
        $('html, body').animate({
          scrollTop: scrollto
        }, 1500, 'easeInOutExpo');
      }
    }
  });

  // Navigation active state on scroll
  var nav_sections = $('section');
  var main_nav = $('.nav-menu, #mobile-nav');

  $(window).on('scroll', function() {
    var cur_pos = $(this).scrollTop() + 200;

    nav_sections.each(function() {
      var top = $(this).offset().top,
        bottom = top + $(this).outerHeight();

      if (cur_pos >= top && cur_pos <= bottom) {
        if (cur_pos <= bottom) {
          main_nav.find('li').removeClass('menu-active');
        }
        main_nav.find('a[href="#' + $(this).attr('id') + '"]').parent('li').addClass('menu-active');
      }
      if (cur_pos < 300) {
        $(".nav-menu li:first").addClass('menu-active');
      }
    });
  });

  // Testimonials carousel (uses the Owl Carousel library)
  $(".testimonials-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      900: {
        items: 3
      }
    }
  });

  // Clients carousel (uses the Owl Carousel library)
  $(".clients-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: {
      0: {
        items: 2
      },
      768: {
        items: 4
      },
      900: {
        items: 6
      }
    }
  });


  // Portfolio details carousel
  $(".portfolio-details-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    items: 1
  });

})(jQuery);

function add_to_cart(id)
{
  if(id!="" && Number.isInteger(id)==true)
  {
    var quantity=$('#quantity_' + id).val();
    $('#cart_result_' + id).show().html("<img width='50px' src='" + base_url + "/assets/img/Spinner.gif'>");
     $.ajax({
        url: base_url + "/cart/add",
        type:"post",
        data:{id:id,quantity:quantity},
        success: function(result){
            var result_decode=JSON.parse(result);
            $('#cart_result_' + id).empty().show().html(result_decode.message).delay(3000).fadeOut(300);
            $(".cart .count").html(result_decode.count);
            if(result_decode.status =="success")
            {
              //$('.product_' + id).html(result_decode.message).attr("disabled","disabled").removeAttr('onclick');
            }
        },
         error: function(){
          alert("Sorry! Product you selected is out of stock.");
        }
      });
  }
  else
  {
     return false;
  }
}

function update_quantity(id)
{
  if(id!="" && Number.isInteger(id)==true)
  {
    var quantity=$('#quantity_' + id).val();
    $('#cart_result_' + id).show().html("<img width='50px' src='" + base_url + "/assets/img/Spinner.gif'>");
     $.ajax({
        url: base_url + "/cart/update",
        type:"post",
        data:{id:id,quantity:quantity},
        success: function(result){
            var result_decode=JSON.parse(result);
            if(result_decode.status =="success")
            {
              window.location.href=base_url + "/cart";
            }
        },
         error: function(){
          alert("Sorry! refresh page first");
        }
      });
  }
  else
  {
     return false;
  }
}

function delete_cart(id)
{
  if(id!="" && Number.isInteger(id)==true)
  {
    var quantity=$('#quantity_' + id).val();
    $('#cart_delete_' + id).show().html("<img width='50px' src='" + base_url + "/assets/img/Spinner.gif'>");
     $.ajax({
        url: base_url + "/cart/delete",
        type:"post",
        data:{id:id},
        success: function(result){
            var result_decode=JSON.parse(result);
            if(result_decode.status =="success")
            {
              window.location.href=base_url + "/cart";
            }
        },
         error: function(){
          alert("Sorry! refresh page first");
        }
      });
  }
  else
  {
     return false;
  }
}

function validate_email(uemail)
{
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(uemail.value.match(mailformat))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function password_validation(password,mx,my)
{
	var passid_len = password.length;
	if (passid_len == 0 ||passid_len >= my || passid_len <= mx)
	{
	return false;
	}
	return true;
}

function login_form()
{
	var error_status=false;
	var error_string="";
	var uemail = document.getElementById("login_email");
	var passid = document.getElementById("login_password").value;
	if(!validate_email(uemail))
	{
		error_status=true;
		error_string+="Please enter valid email address</br>";
	}
	if(!password_validation(passid,6,10))
	{
		error_status=true;
		error_string+="The password should be betwwen 7 and 10 characters.</br>";
	}
	if(error_status==true)
	{
		document.getElementById("login_error").innerHTML  = error_string;
		return false;
	}
	else
	{
		return true;
	}	
}


$('input[type=radio][name=shipping_address_option]').change(function() {
    if (this.value == 'new') {
        $("#new_shipping_address").show();
    }
    else {
        $("#new_shipping_address").hide();
    }
});

$('input[type=radio][name=billing_address_option]').change(function() {
    if (this.value == 'new') {
        $("#new_billing_address").show();
    }
    else {
        $("#new_billing_address").hide();
    }
});

function create_account() {
  var checkBox = document.getElementById("create-account");
  if (checkBox.checked == true){
    $(".hidden-password").show();
  } else {
     $(".hidden-password").hide();
  }
}

function change_shipping_address() {
  var checkBox = document.getElementById("ship-to-diiferent-address");
  if (checkBox.checked == true){
    $("#change_shipping_address").show();
  } else {
     $("#change_shipping_address").hide();
  }
}

function checkout_process(){
return true;
}
change_shipping_address